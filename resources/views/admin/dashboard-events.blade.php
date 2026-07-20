<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-10">
    <div class="p-8 border-b flex justify-between items-center">
        <h3 class="font-black text-xl">Event Terbaru</h3>
        <a href="{{ route('admin.events.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Judul Event</th>
                    <th class="px-8 py-4">Kategori</th>
                    <th class="px-8 py-4">Tanggal</th>
                    <th class="px-8 py-4">Harga</th>
                    <th class="px-8 py-4">Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($recentEvents as $event)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-8 py-6 font-bold text-slate-800">{{ $event->title }}</td>
                        <td class="px-8 py-6 text-slate-600">{{ $event->category->name ?? '-' }}</td>
                        <td class="px-8 py-6 text-slate-600">{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</td>
                        <td class="px-8 py-6 font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</td>
                        <td class="px-8 py-6 font-medium text-slate-600">{{ $event->stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada event terbaru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
