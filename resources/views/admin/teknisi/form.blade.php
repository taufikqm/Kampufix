@extends('layouts.admin')

@section('page_title', isset($teknisi) ? 'Edit Teknisi' : 'Tambah Teknisi')

@section('content')
    <div class="max-w-2xl">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.teknisi.index') }}"
               class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
                <span class="material-symbols-outlined text-gray-600">arrow_back</span>
            </a>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ isset($teknisi) ? 'Edit Profil Teknisi' : 'Tambah Teknisi Baru' }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ isset($teknisi) ? 'Perbarui informasi profil teknisi' : 'Buat akun teknisi baru dengan status on duty' }}
                </p>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl border border-gray-100 p-6">
            <form action="{{ isset($teknisi) ? route('admin.teknisi.update', $teknisi->id) : route('admin.teknisi.store') }}"
                  method="POST" class="space-y-5">
                @csrf
                @if(isset($teknisi))
                    @method('PUT')
                @endif

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name"
                           value="{{ old('name', $teknisi->name ?? '') }}"
                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama lengkap"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email"
                           value="{{ old('email', $teknisi->email ?? '') }}"
                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 @error('email') border-red-500 @enderror"
                           placeholder="contoh@email.com"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password {!! isset($teknisi) ? '<span class="text-gray-400">(kosongkan jika tidak ingin mengubah)</span>' : '<span class="text-red-500">*</span>' !!}
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 @error('password') border-red-500 @enderror"
                           placeholder="Minimal 8 karakter"
                           {{ !isset($teknisi) ? 'required' : '' }}>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                @if(!isset($teknisi))
                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation"
                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500"
                           placeholder="Ulangi password"
                           required>
                </div>
                @endif

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon <span class="text-gray-400">(opsional)</span>
                    </label>
                    <input type="text" 
                           name="phone" 
                           id="phone"
                           value="{{ old('phone', $teknisi->phone ?? '') }}"
                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 @error('phone') border-red-500 @enderror"
                           placeholder="081234567890">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Specialization -->
                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                        Spesialisasi <span class="text-gray-400">(opsional)</span>
                    </label>
                    <input type="text" 
                           name="specialization" 
                           id="specialization"
                           value="{{ old('specialization', $teknisi->specialization ?? '') }}"
                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 @error('specialization') border-red-500 @enderror"
                           placeholder="Contoh: AC, Listrik, Plumbing">
                    @error('specialization')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat <span class="text-gray-400">(opsional)</span>
                    </label>
                    <textarea name="address" 
                              id="address"
                              rows="3"
                              class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 @error('address') border-red-500 @enderror"
                              placeholder="Masukkan alamat lengkap">{{ old('address', $teknisi->address ?? '') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- On Duty Status -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" 
                           name="on_duty" 
                           id="on_duty"
                           value="1"
                           {{ old('on_duty', $teknisi->on_duty ?? false) ? 'checked' : '' }}
                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                    <label for="on_duty" class="text-sm font-medium text-gray-700">
                        Set sebagai On Duty
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-4">
                    <button type="submit"
                            class="px-6 py-2.5 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                        {{ isset($teknisi) ? 'Simpan Perubahan' : 'Tambah Teknisi' }}
                    </button>
                    <a href="{{ route('admin.teknisi.index') }}"
                       class="px-6 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

