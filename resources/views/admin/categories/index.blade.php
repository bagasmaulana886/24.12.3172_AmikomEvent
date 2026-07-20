@extends('layouts.admin')

@section('content')
<div class="p-6">

    <div class="flex justify-between items-center gap-4 mb-6 flex-col md:flex-row">
        <div>
            <h2 class="text-2xl font-bold">Manajemen Kategori</h2>
            <p class="text-sm text-slate-500 mt-1">Cari nama kategori untuk memfilter daftar.</p>
        </div>

        <div class="flex flex-col gap-3 md:flex-row md:items-center">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">
                    Cari
                </button>
            </form>
            <a href="{{ route('admin.categories.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded font-semibold hover:bg-indigo-700">
                Tambah Kategori
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-5 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-5 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full bg-white rounded-lg shadow-sm border border-gray-200 text-left">

            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="p-4 font-semibold text-gray-600">No</th>
                    <th class="p-4 font-semibold text-gray-600">Nama Kategori</th>
                    <th class="p-4 font-semibold text-gray-600">Slug</th>
                    <th class="p-4 font-semibold text-gray-600">Jumlah Event</th>
                    <th class="p-4 font-semibold text-gray-600">Tanggal Dibuat</th>
                    <th class="p-4 font-semibold text-gray-600">Aksi Pilihan</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $index => $category)

                <tr class="border-b border-gray-100 hover:bg-gray-50">

                    <td class="p-4 text-gray-600">
                        {{ $categories->firstItem() + $index }}
                    </td>

                    <td class="p-4 text-gray-800 font-medium">
                        {{ $category->name }}
                    </td>

                    <td class="p-4 text-gray-600 text-sm">
                        {{ $category->slug }}
                    </td>

                    <td class="p-4">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-lg text-sm font-bold">
                            {{ $category->events_count }} Event
                        </span>
                    </td>

                    <td class="p-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($category->created_at)->format('d M Y') }}
                    </td>

                    <td class="p-4 flex gap-2">

                        <a href="{{ route('admin.categories.edit', $category->id) }}"
                           class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1.5 rounded text-sm font-semibold hover:bg-blue-600 hover:text-white transition">
                            Edit Data
                        </a>

                        <form action="{{ route('admin.categories.destroy', $category->id) }}"
                              method="POST"
                              onsubmit="return confirm('Anda yakin ingin menghapus kategori ini secara permanen?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="bg-red-100 text-red-600 border border-red-200 px-3 py-1.5 rounded text-sm font-semibold hover:bg-red-600 hover:text-white transition">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">

                        Belum ada data kategori.

                        <a href="{{ route('admin.categories.create') }}"
                           class="text-indigo-600 font-semibold hover:underline">
                            Tambah kategori sekarang
                        </a>

                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>

</div>
@endsection