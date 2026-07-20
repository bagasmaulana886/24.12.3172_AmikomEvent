@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.categories.index') }}" class="text-indigo-600 font-semibold hover:underline mr-2">← Kembali</a>
        <h2 class="text-2xl font-bold">Edit Kategori</h2>
    </div>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-5 border border-red-200">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="max-w-2xl">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('name') border-red-500 @enderror" placeholder="Masukkan nama kategori" value="{{ old('name', $category->name) }}" required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-2">Slug akan otomatis diperbarui dari nama kategori.</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Slug Saat Ini</label>
                <p class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">{{ $category->slug }}</p>
            </div>

            <div class="mb-6">
                <label for="events_count" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Event (manual)</label>
                <input type="number" name="events_count" id="events_count" min="0" class="w-40 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('events_count') border-red-500 @enderror" placeholder="0" value="{{ old('events_count', $category->events_count ?? 0) }}">
                @error('events_count')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-2">Nilai ini disimpan manual dan tidak otomatis menghitung relasi event.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-semibold hover:bg-indigo-700 transition">
                    Perbarui Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
