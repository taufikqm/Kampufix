@extends('layouts.admin')

@section('page_title', isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
    <div class="max-w-2xl">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.kategori.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                <span class="material-symbols-outlined text-gray-600">arrow_back</span>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ isset($kategori) ? 'Perbarui informasi kategori' : 'Buat kategori baru untuk mengelompokkan pengaduan' }}
                </p>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <form action="{{ isset($kategori) ? route('admin.kategori.update', $kategori->id) : route('admin.kategori.store') }}"
                  method="POST" class="space-y-5">
                @csrf
                @if(isset($kategori))
                    @method('PUT')
                @endif

                <!-- Nama Kategori -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama"
                           value="{{ old('nama', $kategori->nama ?? '') }}"
                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 @error('nama') border-red-500 @enderror"
                           placeholder="Contoh: AC / Pendingin"
                           required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi <span class="text-gray-400">(opsional)</span>
                    </label>
                    <textarea name="deskripsi" 
                              id="deskripsi"
                              rows="3"
                              class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 @error('deskripsi') border-red-500 @enderror"
                              placeholder="Jelaskan jenis pengaduan yang termasuk dalam kategori ini...">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-4">
                    <button type="submit"
                            class="px-6 py-2.5 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                        {{ isset($kategori) ? 'Simpan Perubahan' : 'Tambah Kategori' }}
                    </button>
                    <a href="{{ route('admin.kategori.index') }}"
                       class="px-6 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
