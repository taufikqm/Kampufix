@extends('layouts.admin')

@section('page_title', 'Monitoring Feedback Pengguna')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col justify-between">
                <div>
                    <h5 class="text-sm font-medium text-gray-500 mb-1">Total Feedback</h5>
                    <div class="text-3xl font-bold text-gray-900">{{ $totalFeedback }}</div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500 gap-2">
                    <span class="material-symbols-outlined text-red-500">reviews</span>
                    <span>Ulasan diterima</span>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col justify-between">
                <div>
                    <h5 class="text-sm font-medium text-gray-500 mb-1">Rata-rata Rating</h5>
                    <div class="flex items-baseline gap-2">
                        <div class="text-3xl font-bold text-gray-900">{{ number_format($avgRating, 1) }}</div>
                        <div class="flex items-center text-yellow-500">
                            <span class="material-symbols-outlined text-xl">star</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500 gap-2">
                    <span class="material-symbols-outlined text-yellow-500">star_rate</span>
                    <span>Dari 5.0 bintang</span>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6 flex flex-col justify-between">
                <div>
                    <h5 class="text-sm font-medium text-gray-500 mb-1">Teknisi Terbaik</h5>
                    @if($topTeknisi)
                        <div class="text-lg font-bold text-gray-900 truncate" title="{{ $topTeknisi->name }}">
                            {{ $topTeknisi->name }}
                        </div>
                        <div class="flex items-center gap-1 text-sm text-yellow-500 font-medium">
                            <span class="material-symbols-outlined text-sm">star</span>
                            {{ number_format($topTeknisi->avg_rating, 1) }} 
                            <span class="text-gray-400 font-normal">({{ $topTeknisi->total_feedback }} ulasan)</span>
                        </div>
                    @else
                        <div class="text-lg font-bold text-gray-400">Belum ada data</div>
                    @endif
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500 gap-2">
                    <span class="material-symbols-outlined text-green-500">emoji_events</span>
                    <span>Performa tertinggi</span>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white p-4 rounded-xl border border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Feedback</h2>
            
            <form method="GET" action="{{ route('admin.feedback.index') }}" class="flex items-center gap-2 w-full md:w-auto">
                <select name="teknisi_id" class="rounded-lg border-gray-200 text-sm focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                    <option value="">Semua Teknisi</option>
                    @foreach($teknisiList as $t)
                        <option value="{{ $t->id }}" {{ request('teknisi_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->name }}
                        </option>
                    @endforeach
                </select>

                <select name="rating" class="rounded-lg border-gray-200 text-sm focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                    <option value="">Semua Rating</option>
                    <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                    <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                    <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                    <option value="2" {{ request('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2)</option>
                    <option value="1" {{ request('rating') == 1 ? 'selected' : '' }}>⭐ (1)</option>
                </select>
                
                @if(request()->hasAny(['teknisi_id', 'rating']))
                    <a href="{{ route('admin.feedback.index') }}" class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg text-sm font-medium transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- List Data -->
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teknisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($feedbacks as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold">
                                        {{ substr($item->nama, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item->nama }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->kode }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700 font-medium">{{ $item->teknisi->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex text-yellow-400 text-sm">
                                    @for($i=1; $i<=5; $i++)
                                        <span class="material-symbols-outlined" style="font-size: 16px;">
                                            {{ $i <= $item->rating ? 'star' : 'star_border' }}
                                        </span>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->feedback)
                                    <p class="text-sm text-gray-600 line-clamp-2" title="{{ $item->feedback }}">
                                        "{{ $item->feedback }}"
                                    </p>
                                @else
                                    <span class="text-xs text-gray-400 italic">Tidak ada komentar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $item->updated_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.pengaduan.detail', $item->id) }}" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-gray-300 text-5xl mb-2">reviews</span>
                                <p class="text-gray-500">Belum ada feedback yang ditemukan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($feedbacks->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $feedbacks->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
