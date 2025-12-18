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
                    <p class="text-sm text-gray-500 mb-1">Kategori</p>
                    @if($pengaduan->kategori)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            {{ $pengaduan->kategori->nama }}
                        </span>
                    @else
                        <p class="text-base text-gray-400">Tidak ada kategori</p>
                    @endif
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

        <!-- Progress Pengerjaan (Full CRUD) -->
        <div class="space-y-6 pt-6 border-t border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Riwayat & Progress Pengerjaan</h2>

            <!-- Timeline List -->
            <div class="space-y-4">
                @forelse($pengaduan->progressPengerjaans as $progress)
                    <div class="flex gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div class="flex-shrink-0 mt-1">
                            <span class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm">history</span>
                            </span>
                        </div>
                        <div class="flex-1 space-y-2">
                            <div class="flex justify-between items-start">
                                <p class="text-sm text-gray-500">{{ $progress->created_at->translatedFormat('d F Y, H:i') }}</p>
                                <div class="flex gap-2">
                                    <button onclick="openEditModal('{{ $progress->id }}', '{{ $progress->keterangan }}')" class="text-xs text-blue-600 hover:underline">Edit</button>
                                    <form action="{{ route('teknisi.progress.destroy', $progress->id) }}" method="POST" onsubmit="return confirm('Hapus progress ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-gray-800">{{ $progress->keterangan }}</p>
                            @if($progress->foto)
                                <img src="{{ asset('storage/' . $progress->foto) }}" class="w-24 h-24 object-cover rounded-lg border cursor-pointer" onclick="window.open(this.src)">
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center italic">Belum ada progress yang dilaporkan.</p>
                @endforelse
            </div>

            <!-- Form Tambah Progress -->
            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                <h3 class="font-semibold text-blue-900 mb-4">Lapor Progress Baru</h3>
                <form action="{{ route('teknisi.progress.store', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1">Keterangan Aktivitas</label>
                        <textarea name="keterangan" rows="3" class="w-full rounded-lg border-blue-200 focus:border-blue-500 focus:ring-blue-500 @error('keterangan') border-red-500 @enderror" placeholder="Jelaskan apa yang sudah dikerjakan..." required>{{ old('keterangan') }}</textarea>
                        @error('keterangan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-900 mb-1">Foto Bukti (Opsional)</label>
                        <input type="file" name="foto" class="w-full text-sm text-blue-900 rounded-lg border border-blue-200 cursor-pointer focus:outline-none @error('foto') border-red-500 @enderror">
                        @error('foto') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                        Kirim Laporan
                    </button>
                </form>
            </div>
        </div>

        <!-- Update Status Final -->
        <div class="pt-6 border-t border-gray-200 space-y-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Update Status Akhir</h2>
            
            <form action="{{ route('teknisi.pengaduan.update', $pengaduan->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <select name="status" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 px-4 py-2">
                            <option value="Menunggu" {{ $pengaduan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai (Tutup Tiket)</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Modal Edit Progress -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-lg">
        <h3 class="text-lg font-bold mb-4">Edit Progress</h3>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1">Keterangan</label>
                <textarea id="editKeterangan" name="keterangan" rows="3" class="w-full rounded-lg border-gray-300" required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Ganti Foto (Opsional)</label>
                <input type="file" name="foto" class="w-full text-sm border cursor-pointer">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, keterangan) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editKeterangan').value = keterangan;
        // set action url dynamically
        document.getElementById('editForm').action = "/teknisi/progress/" + id; 
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection

