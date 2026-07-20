@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center gap-4 mb-6 flex-col md:flex-row">
        <div>
            <h2 class="text-2xl font-bold">Manajemen Partner</h2>
            <p class="text-sm text-slate-500 mt-1">Cari partner berdasarkan nama untuk mempercepat pencarian.</p>
        </div>

        <div class="flex flex-col gap-3 md:flex-row md:items-center">
            <form action="{{ route('admin.partners.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari partner..."
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">
                    Cari
                </button>
            </form>
            <a href="{{ route('admin.partners.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded font-semibold hover:bg-indigo-700">Tambah Partner</a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded mb-5 border border-green-200">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded-lg shadow-sm border border-gray-200 text-left">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="p-4 font-semibold text-gray-600">Logo</th>
                    <th class="p-4 font-semibold text-gray-600">Nama Partner</th>
                    <th class="p-4 font-semibold text-gray-600">URL Logo</th>
                    <th class="p-4 font-semibold text-gray-600">Tanggal Dibuat</th>
                    <th class="p-4 font-semibold text-gray-600">Aksi Pilihan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($partners as $partner)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="p-4">
                        <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="w-12 h-12 object-cover rounded">
                    </td>
                    <td class="p-4 text-gray-800 font-medium">{{ $partner->name }}</td>
                    <td class="p-4 text-gray-600 text-sm truncate" title="{{ $partner->logo_url }}">{{ $partner->logo_url }}</td>
                    <td class="p-4 text-gray-600">{{ \Carbon\Carbon::parse($partner->created_at)->format('d M Y') }}</td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('admin.partners.edit', $partner->id) }}" class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1.5 rounded text-sm font-semibold hover:bg-blue-600 hover:text-white transition">Edit Data</a>
                        <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data partner ini secara permanen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded text-sm font-semibold hover:bg-red-600 hover:text-white transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">Belum ada data partner. <a href="{{ route('admin.partners.create') }}" class="text-indigo-600 font-semibold hover:underline">Tambah partner sekarang</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $partners->links() }}
    </div>
</div>
@endsection
