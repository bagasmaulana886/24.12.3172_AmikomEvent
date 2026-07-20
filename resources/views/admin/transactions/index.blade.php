@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Admin')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda.')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-slate-900">Laporan Transaksi</h2>
        <p class="text-slate-500 mt-1">Pantau arus kas dan penjualan tiket Anda.</p>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4">Order ID</th>
                        <th class="px-8 py-4">Detail Pembeli</th>
                        <th class="px-8 py-4">Event</th>
                        <th class="px-8 py-4">Tgl Transaksi</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Total Tagihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/50 transition {{ $trx->status == 'pending' ? 'text-slate-400' : '' }}">
                        <td class="px-8 py-6">
                            <span class="font-mono font-bold px-3 py-1 rounded-lg text-sm {{ $trx->status == 'pending' ? 'bg-slate-100' : 'text-indigo-600 bg-indigo-50' }}">
                                {{ $trx->order_id }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-bold text-slate-800">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-500">{{ $trx->customer_email }}<br>{{ $trx->customer_phone }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-semibold text-slate-800">{{ $trx->event->title ?? 'Event tidak ditemukan' }}</p>
                            <p class="text-xs text-slate-500">{{ $trx->event->category->name ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-6 text-slate-600">{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y, H:i') }}</td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold {{ $trx->status == 'pending' ? 'bg-slate-100 text-slate-500' : 'bg-emerald-50 text-emerald-600' }}">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right font-semibold text-slate-800">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-10 text-center text-slate-500">
                            Belum ada transaksi untuk ditampilkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(method_exists($transactions, 'links'))
    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
