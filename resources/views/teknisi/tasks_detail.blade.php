@extends('layouts.teknisi')

@section('page_title', 'Detail Tugas')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <a href="{{ route('teknisi.tasks') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-800 mb-4">
        <span class="material-symbols-outlined text-base">arrow_back</span>
        Kembali ke Tugas Saya
    </a>
    <div class="bg-white rounded-2xl border border-gray-200 p-8">
        <h1 class="text-2xl font-bold mb-4">Detail Tugas Perbaikan</h1>
        <div class="space-y-2">
            <div class="flex flex-wrap gap-6">
                <div>
                    <p class="text-xs text-gray-500">ID Pengaduan</p>
                    <p class="font-semibold text-lg">{{ $task->kode }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Status</p>
                    @if($task->status == 'Diproses')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Diproses</span>
                    @elseif($task->status == 'Menunggu')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Menunggu</span>
                    @elseif($task->status == 'Selesai')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $task->status }}</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-gray-500">Tanggal</p>
                    <p class="text-sm">{{ $task->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Lokasi</p>
                    <p class="text-sm">{{ $task->lokasi }}</p>
                </div>
            </div>
            <hr class="my-4">
            <p class="text-sm text-gray-500 mb-1">Subjek</p>
            <p class="text-base font-bold text-primary mb-4">{{ $task->subjek }}</p>
            <p class="text-sm text-gray-500 mb-1">Deskripsi</p>
            <p class="mb-4">{{ $task->deskripsi }}</p>
            @if($task->catatan_perbaikan)
                <div class="mt-4">
                    <p class="text-sm text-gray-500 mb-1">Catatan Perbaikan</p>
                    <p class="mb-2 text-gray-800">{{ $task->catatan_perbaikan }}</p>
                </div>
            @endif
            @if($task->foto_perbaikan)
                <div class="mt-2">
                    <p class="text-sm text-gray-500 mb-1">Foto Perbaikan</p>
                    <img src="{{ asset('storage/'.$task->foto_perbaikan) }}" alt="Foto Perbaikan" class="h-48 w-auto rounded border mt-1">
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
