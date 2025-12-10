@extends('layouts.teknisi')

@section('page_title', 'Tugas Saya')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold mb-4">Tugas Saya</h1>
        <p class="text-gray-600">Daftar perbaikan/pengaduan yang ditugaskan ke Anda sebagai teknisi.</p>
    </div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID PENGADUAN</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">SUBJEK</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">TANGGAL</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">STATUS</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">AKSI</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4"><span class="text-sm font-medium text-gray-900">{{ $task->kode }}</span></td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-700">{{ $task->subjek }}</span></td>
                        <td class="px-6 py-4"><span class="text-sm text-gray-600">{{ $task->created_at->format('d M Y') }}</span></td>
                        <td class="px-6 py-4">
                            @if($task->status == 'Diproses')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Diproses</span>
                            @elseif($task->status == 'Menunggu')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Menunggu</span>
                            @elseif($task->status == 'Selesai')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Selesai</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ $task->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('teknisi.tasks.detail', $task->id) }}" class="text-sm text-red-600 hover:text-red-700 font-medium">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada tugas.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($tasks->hasPages())
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan {{ $tasks->firstItem() ?? 0 }}-{{ $tasks->lastItem() ?? 0 }} dari {{ $tasks->total() }} hasil
                </div>
                <div class="flex items-center gap-2">
                    @if($tasks->onFirstPage())
                        <span class="px-3 py-1 text-gray-400 cursor-not-allowed"><span class="material-symbols-outlined text-lg">chevron_left</span></span>
                    @else
                        <a href="{{ $tasks->previousPageUrl() }}" class="px-3 py-1 text-gray-600 hover:text-gray-900"><span class="material-symbols-outlined text-lg">chevron_left</span></a>
                    @endif
                    @foreach($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                        @if($page == $tasks->currentPage())
                            <span class="px-3 py-1 bg-red-600 text-white rounded-lg font-medium">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1 text-gray-600 hover:text-gray-900">{{ $page }}</a>
                        @endif
                    @endforeach
                    @if($tasks->hasMorePages())
                        <a href="{{ $tasks->nextPageUrl() }}" class="px-3 py-1 text-gray-600 hover:text-gray-900"><span class="material-symbols-outlined text-lg">chevron_right</span></a>
                    @else
                        <span class="px-3 py-1 text-gray-400 cursor-not-allowed"><span class="material-symbols-outlined text-lg">chevron_right</span></span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
