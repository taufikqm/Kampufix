@extends('layouts.admin')

@section('page_title', 'Detail Pengaduan')

@section('content')
    @php
        $statusOptions = ['Baru', 'Menunggu', 'Diproses', 'Selesai', 'Ditolak'];
    @endphp

    <div class="flex flex-col gap-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm text-gray-500">{{ $p->subjek }}</p>
                <h1 class="text-3xl font-semibold text-gray-900">Detail Pengaduan: {{ $p->kode ?? 'Tanpa Kode' }}</h1>
                <p class="text-sm text-gray-400 mt-1">{{ $p->lokasi ?? 'Lokasi belum ditentukan' }}</p>
            </div>
            <a href="{{ route('admin.pengaduan.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <section class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-400">Informasi Pengaduan</p>
                        <h2 class="text-xl font-semibold text-gray-900 mt-1">Detail Laporan</h2>
                    </div>
                    <span class="px-4 py-1 rounded-full text-sm font-semibold
                        @class([
                            'bg-blue-50 text-blue-600' => $p->status === 'Baru',
                            'bg-amber-50 text-amber-600' => $p->status === 'Diproses',
                            'bg-emerald-50 text-emerald-600' => $p->status === 'Selesai',
                            'bg-rose-50 text-rose-600' => $p->status === 'Ditolak',
                            'bg-gray-100 text-gray-600' => !in_array($p->status, ['Baru','Diproses','Selesai','Ditolak']),
                        ])">
                        {{ $p->status }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-400 text-xs uppercase">ID Pengaduan</p>
                        <p class="font-semibold text-gray-900">{{ $p->kode ?? 'Belum tersedia' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs uppercase">Tanggal Diajukan</p>
                        <p class="font-semibold text-gray-900">{{ $p->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs uppercase">Pelapor</p>
                        <p class="font-semibold text-gray-900">{{ $p->nama }}</p>
                        <p class="text-gray-500">{{ $p->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs uppercase">Lokasi</p>
                        <p class="font-semibold text-gray-900">{{ $p->lokasi ?? 'Tidak tercantum' }}</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-gray-400 text-xs uppercase">Deskripsi</p>
                    <p class="text-gray-700 leading-relaxed">{{ $p->deskripsi }}</p>
                </div>

                <div class="space-y-3">
                    <p class="text-gray-400 text-xs uppercase">Lampiran</p>
                    <div class="flex gap-3 flex-wrap">
                        @if($p->foto)
                            <img src="{{ asset('storage/'.$p->foto) }}" alt="Lampiran pengaduan" class="h-28 w-40 object-cover rounded-xl border border-gray-100">
                        @else
                            <div class="h-28 w-40 rounded-xl border border-dashed border-gray-200 flex items-center justify-center text-sm text-gray-400">
                                Tidak ada foto
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dokumentasi Perbaikan -->
                @if($p->catatan_perbaikan || $p->foto_perbaikan)
                <div class="pt-6 border-t border-gray-200 space-y-4">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-400">Dokumentasi Perbaikan</p>
                        <h3 class="text-lg font-semibold text-gray-900 mt-1">Hasil Perbaikan oleh Teknisi</h3>
                    </div>

                    @if($p->catatan_perbaikan)
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700">Catatan Perbaikan</p>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $p->catatan_perbaikan }}</p>
                        </div>
                    </div>
                    @endif

                    @if($p->foto_perbaikan)
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700">Foto Perbaikan</p>
                        <div class="flex gap-3 flex-wrap">
                            <img src="{{ asset('storage/'.$p->foto_perbaikan) }}" alt="Foto perbaikan" class="max-w-full h-auto rounded-xl border border-gray-100 shadow-sm">
                        </div>
                    </div>
                    @endif

                    @if($p->teknisi)
                    <div class="text-xs text-gray-500">
                        <p>Diperbaiki oleh: <span class="font-medium">{{ $p->teknisi->name }}</span></p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Feedback Mahasiswa -->
                @if($p->status === 'Selesai' && ($p->rating || $p->feedback))
                    <div class="pt-6 border-t border-gray-200 space-y-4">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-400">Feedback Mahasiswa</p>
                            <h3 class="text-lg font-semibold text-gray-900 mt-1 mb-2">Penilaian Mahasiswa terhadap Teknisi</h3>
                        </div>
                        <div class="bg-yellow-50 rounded-lg border border-yellow-100 p-4">
                            <div class="flex gap-2 items-center mb-1">
                                @if($p->rating)
                                    <div class="flex items-center gap-1 text-yellow-500 text-xl font-bold">
                                        @for($i=1;$i<=5;$i++)
                                            <span class="material-symbols-outlined align-middle" style="font-size: 22px;line-height:1;">{{ $i <= $p->rating ? 'star' : 'star_half' }}</span>
                                        @endfor
                                        <span class="text-gray-700 ml-2 text-base font-medium">{{ number_format($p->rating, 1) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500 text-sm">Belum ada rating</span>
                                @endif
                            </div>
                            @if($p->feedback)
                                <blockquote class="italic text-gray-800 border-l-4 border-yellow-400 pl-4 mt-1">“{{ $p->feedback }}”</blockquote>
                            @else
                                <p class="text-sm text-gray-500">Belum ada testimoni tertulis.</p>
                            @endif
                        </div>
                    </div>
                @endif
            </section>

            <section class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <p class="text-xs uppercase tracking-wide text-gray-400">Manajemen Status</p>
                    <h3 class="text-xl font-semibold text-gray-900 mt-1 mb-4">Perbarui Status</h3>

                    <form action="{{ route('admin.pengaduan.update', $p->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-600">Ubah Status</label>
                            <select name="status" id="statusSelect" class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500">
                                @foreach($statusOptions as $status)
                                    <option value="{{ $status }}" @selected($status === $p->status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="space-y-2" id="teknisiField" style="display: {{ in_array($p->status, ['Menunggu', 'Diproses', 'Selesai']) ? 'block' : 'none' }};">
                            <label class="text-sm font-medium text-gray-600">Tugaskan ke Teknisi</label>
                            <select name="teknisi_id" class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500">
                                <option value="">Pilih Teknisi</option>
                                @foreach($teknisiList as $teknisi)
                                    <option value="{{ $teknisi->id }}" @selected($p->teknisi_id == $teknisi->id)>
                                        {{ $teknisi->name }} ({{ $teknisi->email }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Pilih teknisi yang akan menangani pengaduan ini</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-600">Komentar / Catatan Internal</label>
                            <textarea class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 min-h-[120px]" placeholder="Tambahkan catatan untuk tim..."></textarea>
                        </div>

                        <button class="w-full rounded-xl bg-red-600 text-white font-semibold py-3 hover:bg-red-700 transition">
                            Simpan Perubahan
                        </button>
                    </form>
                    
                    <script>
                        document.getElementById('statusSelect').addEventListener('change', function() {
                            const teknisiField = document.getElementById('teknisiField');
                            if (['Menunggu', 'Diproses', 'Selesai'].includes(this.value)) {
                                teknisiField.style.display = 'block';
                            } else {
                                teknisiField.style.display = 'none';
                            }
                        });
                    </script>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <p class="text-xs uppercase tracking-wide text-gray-400">Riwayat Status</p>
                    <h3 class="text-xl font-semibold text-gray-900 mt-1 mb-4">Timeline</h3>

                    <div class="space-y-6">
                        <div class="relative pl-6">
                            <span class="absolute left-0 top-1.5 h-3 w-3 rounded-full bg-amber-500"></span>
                            <p class="text-sm font-semibold text-gray-900">Status menjadi {{ $p->status }}</p>
                            <p class="text-xs text-gray-500">{{ $p->updated_at->translatedFormat('d M Y, H:i') }}</p>
                            <p class="text-sm text-gray-600 mt-1">Status terakhir diperbarui oleh admin.</p>
                        </div>
                        <div class="relative pl-6">
                            <span class="absolute left-0 top-1.5 h-3 w-3 rounded-full bg-gray-400"></span>
                            <p class="text-sm font-semibold text-gray-900">Pengaduan dibuat</p>
                            <p class="text-xs text-gray-500">{{ $p->created_at->translatedFormat('d M Y, H:i') }}</p>
                            <p class="text-sm text-gray-600 mt-1">Laporan diajukan oleh {{ $p->nama }}.</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

