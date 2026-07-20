@extends('layouts.app')

@section('title', 'Pembayaran - ' . $transaction->event->title)

@section('content')
<main class="max-w-3xl mx-auto px-6 py-20 text-center">
    <div class="bg-white rounded-3xl border border-slate-200 p-12 shadow-sm inline-block w-full max-w-md">
        <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-black mb-2">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-8">Mohon selesaikan pembayaran tiket Anda untuk event <strong>{{ $transaction->event->title }}</strong>.</p>
        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 mb-8">
            <p class="text-sm text-slate-400 font-bold uppercase tracking-wider mb-1">Total Tagihan</p>
            <h3 class="text-4xl font-extrabold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-400 mt-2">Order ID: {{ $transaction->order_id }}</p>
        </div>

        @if(isset($mockMode) && $mockMode)
            <div class="mb-6 p-4 rounded-2xl bg-amber-100 border border-amber-200 text-amber-900 text-sm text-left">
                <strong>Mode Demo:</strong> Kunci Midtrans belum dikonfigurasi atau masih placeholder.
                Pembayaran akan menggunakan alur dummy agar Anda tetap bisa melanjutkan.
            </div>
        @endif

        <button id="pay-button" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition animate-bounce-in">
            Bayar Sekarang
        </button>

        @if(app()->isLocal() || config('app.debug'))
            <div class="mt-4 space-y-3">
                <form action="{{ route('checkout.forceSuccess', $transaction->order_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-base hover:bg-emerald-700 transition">
                        Tandai Pembayaran Berhasil (Pengujian Lokal)
                    </button>
                </form>
                <a href="{{ route('checkout.forceSuccess.get', $transaction->order_id) }}" class="block w-full text-center py-4 bg-slate-900 text-white rounded-2xl font-black text-base hover:bg-slate-700 transition">
                    Tandai Berhasil via Link Langsung
                </a>
            </div>
        @endif
    </div>
</main>

@if(!isset($mockMode) || !$mockMode)
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            snap.pay('{{ $transaction->snap_token }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route('checkout.success', $transaction->order_id) }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route('checkout.success', $transaction->order_id) }}';
                },
                onError: function(result) {
                    alert('Pembayaran Gagal!');
                }
            });
        };

        window.onload = function() {
            document.getElementById('pay-button').click();
        };
    </script>
@else
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            alert('Mode demo: pembayaran dummy berhasil. Anda akan diarahkan ke halaman sukses.');
            window.location.href = '{{ route('checkout.success', $transaction->order_id) }}';
        };

        window.onload = function() {
            document.getElementById('pay-button').click();
        };
    </script>
@endif

<style>
    @keyframes bounce-in {
        0% { transform: scale(0.9); opacity: 0; }
        70% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); }
    }
    .animate-bounce-in { animation: bounce-in 0.4s ease-out forwards; }
</style>
@endsection
