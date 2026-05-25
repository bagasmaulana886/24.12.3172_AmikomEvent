@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Form Tambah Event</h2>
    <form action="{{ route('admin.events.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mt-2">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Judul Event</label>
            <input type="text" name="title" class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200 @error('title') border-red-500 @enderror" required>
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Kategori Event</label>
            <select name="category_id" class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200 @error('category_id') border-red-500 @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-medium text-gray-700">Deskripsi Pendek</label>
            <textarea name="description" class="w-full border border-gray-300 p-2.5 rounded focus:ring focus:ring-indigo-200 @error('description') border-red-500 @enderror" rows="3" required></textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-4">
            <div>
                <label class="block mb-2 font-medium text-gray-700">Tanggal & Waktu</label>
                <input type="datetime-local" name="date" class="w-full border border-gray-300 p-2.5 rounded @error('date') border-red-500 @enderror" required>
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Harga Tiket (Rp)</label>
                <input type="number" name="price" class="w-full border border-gray-300 p-2.5 rounded @error('price') border-red-500 @enderror" required>
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block mb-2 font-medium text-gray-700">Kapasitas Stok</label>
                <input type="number" name="stock" class="w-full border border-gray-300 p-2.5 rounded @error('stock') border-red-500 @enderror" required>
                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-medium text-gray-700">Lokasi / Gedung</label>
            <input type="text" name="location" class="w-full border border-gray-300 p-2.5 rounded @error('location') border-red-500 @enderror" required>
            @error('location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end border-t pt-4">
            <a href="{{ route('admin.events.index') }}" class="text-gray-600 px-6 py-2.5 rounded font-semibold border border-gray-200 hover:bg-gray-50 mr-2">Batal</a>
            <button type="submit" class="bg-indigo-600 text-white px-8 py-2.5 rounded font-semibold hover:bg-indigo-700 shadow">Simpan Data</button>
        </div>
    </form>
</div>
@endsection
