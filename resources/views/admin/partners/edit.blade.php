@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.partners.index') }}" class="text-indigo-600 font-semibold hover:underline mr-2">← Kembali</a>
        <h2 class="text-2xl font-bold">Edit Data Partner</h2>
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
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Partner</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('name') border-red-500 @enderror" placeholder="Nama perusahaan partner" value="{{ old('name', $partner->name) }}" required>
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="logo_url" class="block text-sm font-semibold text-gray-700 mb-2">URL Logo</label>
                <input type="text" name="logo_url" id="logo_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('logo_url') border-red-500 @enderror" placeholder="https://placehold.co/200x200" value="{{ old('logo_url', $partner->logo_url) }}" required>
                @error('logo_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-2">Contoh: https://placehold.co/200x200</p>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600">Preview Logo Saat Ini:</p>
                <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="w-24 h-24 object-cover rounded mt-2 border border-gray-200">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded font-semibold hover:bg-indigo-700 transition">
                    Perbarui Partner
                </button>
                <a href="{{ route('admin.partners.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded font-semibold hover:bg-gray-300 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
