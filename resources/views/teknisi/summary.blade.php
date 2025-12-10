@extends('layouts.teknisi')

@section('page_title', 'Ringkasan Pengaduan')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl border p-8">
    <a href="{{ route('teknisi.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-800 mb-4">
        <span class="material-symbols-outlined">arrow_back</span>
        Kembali ke Dashboard
    </a>
    <h1 class="text-2xl font-bold mb-4">Ringkasan Pengaduan</h1>
    <div class="space-y-2 mb-6">
        <div class="flex gap-6 flex-wrap">
            <div>
                <p class="text-xs text-gray-500">ID Pengaduan</p>
                <p class="font-semibold text-lg">{{ $pengaduan->kode }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Status</p>
                @if($pengaduan->status == 'Diproses')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Diproses</span>
                @elseif($pengaduan->status == 'Menunggu')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Menunggu</span>
                @elseif($pengaduan->status == 'Selesai')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $pengaduan->status }}</span>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500">Tanggal</p>
                <p class="text-sm">{{ $pengaduan->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
        <hr class="my-4">
        <p class="text-sm text-gray-500 mb-1">Subjek</p>
        <p class="text-base font-bold text-primary mb-4">{{ $pengaduan->subjek }}</p>
        <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
        <p class="mb-4">{{ $pengaduan->deskripsi }}</p>

        @if($pengaduan->catatan_perbaikan || $pengaduan->foto_perbaikan)
            <div class="mt-6 space-y-2">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Dokumentasi Perbaikan</h2>
                @if($pengaduan->catatan_perbaikan)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Catatan Perbaikan</p>
                        <p class="bg-gray-50 rounded-lg p-3 text-gray-800 mb-2">{{ $pengaduan->catatan_perbaikan }}</p>
                    </div>
                @endif
                @if($pengaduan->foto_perbaikan)
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Foto Perbaikan</p>
                        <img src="{{ asset('storage/' . $pengaduan->foto_perbaikan) }}" alt="Foto Perbaikan" class="h-48 w-auto rounded-lg border">
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
