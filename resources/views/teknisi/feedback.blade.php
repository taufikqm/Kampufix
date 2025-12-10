@extends('layouts.teknisi')

@section('page_title', 'Feedback Mahasiswa')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold mb-2">Monitoring Umpan Balik Teknisi</h1>
        <p class="text-lg text-gray-600">Tinjau semua umpan balik yang diberikan oleh mahasiswa terkait pekerjaan Anda.</p>
    </div>

    @forelse($feedbacks as $f)
        <div class="bg-white border rounded-2xl p-8 shadow-sm flex flex-col gap-3 mb-6">
            <div class="flex justify-between items-start mb-2 flex-wrap gap-2">
                <div>
                    <div class="font-semibold text-lg text-gray-800 mb-0.5">Pengaduan #{{ str_pad($f->kode, 4, '0', STR_PAD_LEFT) }}: {{ $f->subjek }}</div>
                    <div class="text-sm text-gray-500 mb-1">Diajukan oleh: {{ $f->nama }}</div>
                </div>
                @if($f->rating)
                <div class="flex items-center gap-1 text-yellow-500 text-lg font-bold">
                    @for($i=1;$i<=5;$i++)
                        <span class="material-symbols-outlined align-middle" style="font-size: 22px;line-height:1;">{{ $i <= $f->rating ? 'star' : 'star_half' }}</span>
                    @endfor
                    <span class="text-gray-600 ml-2 text-base font-medium">{{ number_format($f->rating, 1) }}</span>
                </div>
                @endif
            </div>
            @if($f->feedback)
            <blockquote class="italic text-gray-700 border-l-4 border-primary pl-4 mt-1">“{{ $f->feedback }}”</blockquote>
            @endif
        </div>
    @empty
        <div class="bg-white border rounded-2xl p-8 text-center text-gray-400">Belum ada feedback dari mahasiswa.</div>
    @endforelse
</div>
@endsection
