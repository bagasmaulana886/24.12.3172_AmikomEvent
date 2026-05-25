@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Edit Kategori</h2>
        <p class="text-gray-600 text-sm">Perbarui informasi kategori di bawah ini.</p>
    </div>

    @if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-5 border border-red-200">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-semibold text-gray-700 mb-2">Nama Kategori</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Masukkan nama kategori" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-indigo-600" required>
                @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block font-semibold text-gray-700 mb-2">Slug (Otomatis)</label>
                <input type="text" id="slug" name="slug" value="{{ $category->slug }}" class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100" disabled>
                <p class="text-gray-500 text-sm mt-1">Slug akan dihasilkan otomatis dari nama kategori</p>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-semibold hover:bg-indigo-700">Simpan Perubahan</button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded font-semibold hover:bg-gray-600">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
