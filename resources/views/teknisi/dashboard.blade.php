@extends('layouts.teknisi')

@section('page_title', 'Dashboard Tugas Teknisi')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div>
        <p class="text-gray-600 mb-4">Daftar pengaduan yang ditugaskan kepada Anda.</p>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search Bar -->
            <div class="flex-1 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                    search
                </span>
                <form method="GET" action="{{ route('teknisi.dashboard') }}" class="flex" id="searchForm">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari berdasarkan ID atau subjek..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                        onkeypress="if(event.key === 'Enter') document.getElementById('searchForm').submit();"
                    >
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>
            </div>

            <!-- Filter Button -->
            <div class="relative">
                <form method="GET" action="{{ route('teknisi.dashboard') }}" id="filterForm">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select 
                        name="status" 
                        onchange="document.getElementById('filterForm').submit();"
                        class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-10 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none cursor-pointer"
                    >
                        <option value="">Filter Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                        arrow_drop_down
                    </span>
                </form>
            </div>
        </div>
    </div>

    <!-- Table Section -->
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
                    @forelse($pengaduans as $pengaduan)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $pengaduan->kode }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700">{{ $pengaduan->subjek }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600">{{ $pengaduan->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($pengaduan->status == 'Diproses')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Diproses
                                </span>
                            @elseif($pengaduan->status == 'Menunggu')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Menunggu
                                </span>
                            @elseif($pengaduan->status == 'Selesai')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $pengaduan->status }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('teknisi.pengaduan.detail', $pengaduan->id) }}" class="text-sm text-red-600 hover:text-red-700 font-medium">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada pengaduan yang ditugaskan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($pengaduans->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Menampilkan {{ $pengaduans->firstItem() ?? 0 }}-{{ $pengaduans->lastItem() ?? 0 }} dari {{ $pengaduans->total() }} hasil
            </div>
            <div class="flex items-center gap-2">
                @if($pengaduans->onFirstPage())
                    <span class="px-3 py-1 text-gray-400 cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $pengaduans->previousPageUrl() }}" class="px-3 py-1 text-gray-600 hover:text-gray-900">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </a>
                @endif

                @foreach($pengaduans->getUrlRange(1, $pengaduans->lastPage()) as $page => $url)
                    @if($page == $pengaduans->currentPage())
                        <span class="px-3 py-1 bg-red-600 text-white rounded-lg font-medium">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 text-gray-600 hover:text-gray-900">{{ $page }}</a>
                    @endif
                @endforeach

                @if($pengaduans->hasMorePages())
                    <a href="{{ $pengaduans->nextPageUrl() }}" class="px-3 py-1 text-gray-600 hover:text-gray-900">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </a>
                @else
                    <span class="px-3 py-1 text-gray-400 cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Floating Action Button -->
<button class="fixed bottom-8 right-8 w-14 h-14 bg-gray-800 hover:bg-gray-900 text-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110">
    <span class="material-symbols-outlined text-white">edit</span>
</button>
@endsection
