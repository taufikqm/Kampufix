@extends('layouts.teknisi')

@section('page_title', 'Detail Pengaduan Kerusakan')

@section('content')
<div class="space-y-6">
    <div class="mb-4">
        <a href="{{ route('teknisi.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-800">
            <span class="material-symbols-outlined text-base">arrow_back</span>
            Kembali ke Dashboard
        </a>
    </div>
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Pengaduan Kerusakan</h1>
        <p class="text-gray-600">Tinjau detail laporan dan perbarui status pengerjaan.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-gray-200 p-8 space-y-8">
        
        <!-- Complaint Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-200">
            <div>
                <p class="text-sm text-gray-500 mb-1">ID Pengaduan</p>
                <p class="text-lg font-semibold text-gray-900">{{ $pengaduan->kode }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Status</p>
                @if($pengaduan->status == 'Diproses')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                        Diproses
                    </span>
                @elseif($pengaduan->status == 'Menunggu')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        Menunggu
                    </span>
                @elseif($pengaduan->status == 'Selesai')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Selesai
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        {{ $pengaduan->status }}
                    </span>
                @endif
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Pelapor</p>
                <p class="text-lg font-semibold text-gray-900">{{ $pengaduan->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Tanggal Lapor</p>
                <p class="text-lg font-semibold text-gray-900">{{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Informasi Detail -->
        <div class="space-y-6">
            <h2 class="text-xl font-semibold text-gray-900">Informasi Detail</h2>
            
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Subjek Pengaduan</p>
                    <p class="text-base font-medium text-gray-900">{{ $pengaduan->subjek }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 mb-1">Lokasi</p>
                    <p class="text-base font-medium text-gray-900">{{ $pengaduan->lokasi ?? 'Lokasi belum ditentukan' }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-gray-500 mb-1">Deskripsi Lengkap</p>
                    <p class="text-base text-gray-700 leading-relaxed">{{ $pengaduan->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Foto/Dokumentasi -->
        @if($pengaduan->foto)
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-900">Foto/Dokumentasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="w-full h-64 object-cover">
                </div>
                @if($pengaduan->foto)
                    <!-- Jika ada foto kedua, bisa ditambahkan di sini -->
                @endif
            </div>
        </div>
        @endif

        <!-- Update Status & Aksi -->
        <div class="pt-6 border-t border-gray-200 space-y-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Update Status & Aksi</h2>
            
            <form action="{{ route('teknisi.pengaduan.update', $pengaduan->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status Pengaduan</label>
                        <select name="status" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 px-4 py-2">
                            <option value="">Pilih status baru...</option>
                            <option value="Menunggu" {{ $pengaduan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                            Simpan Status
                        </button>
                    </div>
                </div>
            </form>

            <div>
                <a href="{{ route('teknisi.pengaduan.dokumentasi', $pengaduan->id) }}" class="w-full md:w-auto bg-gray-800 hover:bg-gray-900 text-white font-semibold px-6 py-2 rounded-lg transition inline-flex items-center gap-2">
                    <span class="material-symbols-outlined">upload</span>
                    Upload Dokumentasi Perbaikan
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

