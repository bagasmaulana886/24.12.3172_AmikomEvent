<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\EventTicketMail;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transaction->status === 'settlement' || $transaction->status === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            } elseif ($fraudStatus == 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaction->status = 'settlement';
            $this->processSuccess($transaction);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        } elseif ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->save();

        return response()->json(['message' => 'OK']);
    }

    private function processSuccess(Transaction $transaction): void
    {
        $event = $transaction->event;

        // Gunakan operasi atomic untuk menghindari race condition
        if ($event) {
            $decremented = DB::table('events')
                ->where('id', $event->id)
                ->where('stock', '>', 0)
                ->decrement('stock');

            if ($decremented) {
                // Segar kembali model event jika diperlukan oleh alur lain
                $event->refresh();

                try {
                    if (!empty($transaction->customer_email)) {
                        Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
                    } else {
                        Log::warning('Transaksi tidak memiliki email pelanggan, tidak dapat mengirim E-Ticket. Order: ' . $transaction->order_id);
                    }
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
                }
            } else {
                // Stok tidak bisa dikurangi (mungkin habis) — catat untuk tindak lanjut
                Log::warning('Gagal mengurangi stok (mungkin habis) setelah pembayaran berhasil. Order: ' . $transaction->order_id);
                // Di sini bisa ditambahkan panggilan refund otomatis jika diinginkan
            }
        } else {
            Log::warning('Transaksi tidak terkait event saat proses success. Order: ' . $transaction->order_id);
        }
    }
}
