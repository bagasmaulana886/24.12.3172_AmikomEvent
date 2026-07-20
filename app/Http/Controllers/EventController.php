<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\EventTicketMail;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $categories = Category::all();

        return view('event-detail', compact('event', 'categories'));
    }

    public function checkout(Event $event)
    {
        return view('checkout', compact('event'));
    }

    public function processCheckout(Request $request, Event $event)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:25',
        ]);

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'TRX-' . strtoupper(Str::random(8)),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'total_price' => $event->price + 5000,
            'status' => 'pending',
        ]);

        $totalPrice = $event->price + 5000;

        if ($this->hasValidMidtransConfig()) {
            try {
                $this->configureMidtrans();

                $params = [
                    'transaction_details' => [
                        'order_id' => $transaction->order_id,
                        'gross_amount' => $totalPrice,
                    ],
                    'customer_details' => [
                        'first_name' => $validated['customer_name'],
                        'email' => $validated['customer_email'],
                        'phone' => $validated['customer_phone'],
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $transaction->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        }

        return redirect()->route('checkout.payment', $transaction->order_id);
    }

    public function payment($order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        $mockMode = !$this->hasValidMidtransConfig() || empty($transaction->snap_token);

        return view('checkout.payment', compact('transaction', 'categories', 'mockMode'));
    }

    public function forceSuccess($order_id)
    {
        if (app()->environment('production')) {
            abort(403, 'Not allowed in production.');
        }

        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();
        $transaction->update(['status' => 'success']);

        return redirect()->route('checkout.success', $order_id)->with('success', 'Transaksi telah ditandai berhasil untuk pengujian.');
    }

    public function success($order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();
        $mockMode = !$this->hasValidMidtransConfig() || empty($transaction->snap_token);

        if ($this->hasValidMidtransConfig() && !empty($transaction->snap_token)) {
            try {
                $this->configureMidtrans();

                $midtransStatus = \Midtrans\Transaction::status($order_id);

                if (in_array($midtransStatus->transaction_status, ['capture', 'settlement'])) {
                    $wasPending = strtolower($transaction->status) === 'pending';
                    $transaction->update(['status' => 'success']);
                    if ($wasPending) {
                        $this->performSuccessActions($transaction);
                    }
                } elseif (app()->isLocal() || config('app.debug')) {
                    // Local/sandbox testing fallback: tampilkan sukses walau API Midtrans masih pending.
                    $wasPending = strtolower($transaction->status) === 'pending';
                    $transaction->update(['status' => 'success']);
                    if ($wasPending) {
                        $this->performSuccessActions($transaction);
                    }
                }
            } catch (\Exception $e) {
                if (app()->isLocal() || config('app.debug')) {
                        $wasPending = strtolower($transaction->status) === 'pending';
                        $transaction->update(['status' => 'success']);
                        if ($wasPending) {
                            $this->performSuccessActions($transaction);
                        }
                } else {
                    return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
                }
            }
        } else {
            if ($transaction->status === 'pending') {
                $transaction->update(['status' => 'success']);
                $this->performSuccessActions($transaction);
            }
        }

        return view('checkout.success', compact('transaction', 'categories', 'mockMode'));
    }

    /**
     * Perform stock decrement and send E-Ticket email when transaction becomes successful.
     *
     * @param Transaction $transaction
     * @return void
     */
    private function performSuccessActions(Transaction $transaction): void
    {
        $transaction->load('event');

        $event = $transaction->event;
        if ($event) {
            $decremented = DB::table('events')
                ->where('id', $event->id)
                ->where('stock', '>', 0)
                ->decrement('stock');

            if ($decremented) {
                $event->refresh();
                try {
                    if (!empty($transaction->customer_email)) {
                        Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
                    } else {
                        Log::warning('Transaksi tidak memiliki email pelanggan, tidak dapat mengirim E-Ticket. Order: ' . $transaction->order_id);
                    }
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email ETicket secara manual (Bypass): ' . $e->getMessage());
                }
            } else {
                Log::warning('Gagal mengurangi stok (mungkin habis) setelah pembayaran berhasil. Order: ' . $transaction->order_id);
                // Di sini bisa ditambahkan panggilan refund otomatis jika diinginkan
            }
        } else {
            Log::warning('Transaksi tidak terkait event saat process success (fallback). Order: ' . $transaction->order_id);
        }
    }

    private function hasValidMidtransConfig(): bool
    {
        $serverKey = trim(env('MIDTRANS_SERVER_KEY', ''));
        $clientKey = trim(env('MIDTRANS_CLIENT_KEY', ''));

        if (empty($serverKey) || empty($clientKey)) {
            return false;
        }

        $placeholders = [
            'SB-Mid-server-demo',
            'SB-Mid-client-demo',
            'YOUR_SERVER_KEY',
            'YOUR_CLIENT_KEY',
        ];

        return !in_array($serverKey, $placeholders, true) && !in_array($clientKey, $placeholders, true);
    }

    private function configureMidtrans(): void
    {
        $serverKey = trim(env('MIDTRANS_SERVER_KEY', ''));
        $clientKey = trim(env('MIDTRANS_CLIENT_KEY', ''));

        if (empty($serverKey) || empty($clientKey)) {
            throw new \RuntimeException('Midtrans key tidak ditemukan. Pastikan MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY sudah terisi di .env.');
        }

        if (in_array($serverKey, ['SB-Mid-server-demo', 'YOUR_SERVER_KEY'], true) || in_array($clientKey, ['SB-Mid-client-demo', 'YOUR_CLIENT_KEY'], true)) {
            throw new \RuntimeException('Midtrans key masih placeholder demo. Ganti dengan sandbox key yang benar dari dashboard Midtrans.');
        }

        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function ticket(Transaction $transaction = null)
    {
        if (!$transaction) {
            $transaction = Transaction::with('event')->latest()->first();
        }

        if (!$transaction) {
            abort(404, 'Transaksi tidak ditemukan.');
        }

        $transaction->load('event');

        return view('ticket', compact('transaction'));
    }
}
