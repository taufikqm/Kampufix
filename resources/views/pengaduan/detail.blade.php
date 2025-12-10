<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Detail Pengaduan - KampuFix</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#D93025",
                        "background-light": "#FAFAFA",
                        "background-dark": "#121212",
                        "surface-light": "#FFFFFF",
                        "surface-dark": "#1E1E1E",
                        "text-primary-light": "#4F4F4F",
                        "text-primary-dark": "#E0E0E0",
                        "text-secondary-light": "#757575",
                        "text-secondary-dark": "#BDBDBD",
                        "border-light": "#E0E0E0",
                        "border-dark": "#424242",
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark">
<div class="flex min-h-screen">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r">
        <div class="p-4 flex flex-col h-full justify-between">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-3 text-primary px-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 2a8 8 0 100 16 8 8 0 000-16zM8.707 14.707a1 1 0 001.414 0L14 10.828V12a1 1 0 102 0V8a1 1 0 00-1-1h-4a1 1 0 100 2h1.172L8.707 12.293a1 1 0 000 1.414zM6 6a1 1 0 100 2h4a1 1 0 100-2H6z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold text-primary">KampuFix</h2>
                </div>
                <div class="flex flex-col gap-2">
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10"
                       href="{{ route('mahasiswa.dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <p class="text-sm font-medium">Dasbor</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10"
                       href="{{ route('mahasiswa.dashboard', ['tab' => 'riwayat']) }}">
                        <span class="material-symbols-outlined">history</span>
                        <p class="text-sm font-medium">Riwayat Pengaduan</p>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1">
        <header class="flex items-center justify-end border-b px-10 py-3 bg-white">
            <div class="flex items-center gap-4">
                <div class="flex gap-3 items-center">
                    <div class="size-10 rounded-full bg-cover bg-center"
                         style='background-image:url("https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}");'></div>
                    <div class="flex flex-col text-right">
                        <h1 class="font-medium">{{ Auth::user()->name }}</h1>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">logout</span>
                        <span class="text-sm font-medium">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="p-8 space-y-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Pengaduan</h1>
                    <p class="text-gray-600">{{ $pengaduan->kode }}</p>
                </div>
                <a href="{{ route('mahasiswa.dashboard', ['tab' => 'riwayat']) }}" 
                   class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 font-medium">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-6">
                <!-- Status Badge -->
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Pengaduan</h2>
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

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Subjek</p>
                        <p class="font-semibold text-gray-900">{{ $pengaduan->subjek }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Lokasi</p>
                        <p class="font-semibold text-gray-900">{{ $pengaduan->lokasi ?? 'Tidak tercantum' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Tanggal Lapor</p>
                        <p class="font-semibold text-gray-900">{{ $pengaduan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Email</p>
                        <p class="font-semibold text-gray-900">{{ $pengaduan->email }}</p>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-700">Deskripsi</p>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $pengaduan->deskripsi }}</p>
                    </div>
                </div>

                <!-- Foto Pengaduan -->
                @if($pengaduan->foto)
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-700">Foto Pengaduan</p>
                    <div class="flex gap-3 flex-wrap">
                        <img src="{{ asset('storage/'.$pengaduan->foto) }}" alt="Foto pengaduan" class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm">
                    </div>
                </div>
                @endif

                <!-- Dokumentasi Perbaikan -->
                @if($pengaduan->catatan_perbaikan || $pengaduan->foto_perbaikan)
                <div class="pt-6 border-t border-gray-200 space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Dokumentasi Perbaikan</h3>
                        <p class="text-sm text-gray-500">Hasil perbaikan yang telah dilakukan oleh teknisi</p>
                    </div>

                    @if($pengaduan->catatan_perbaikan)
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700">Catatan Perbaikan</p>
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $pengaduan->catatan_perbaikan }}</p>
                        </div>
                    </div>
                    @endif

                    @if($pengaduan->foto_perbaikan)
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-700">Foto Perbaikan</p>
                        <div class="flex gap-3 flex-wrap">
                            <img src="{{ asset('storage/'.$pengaduan->foto_perbaikan) }}" alt="Foto perbaikan" class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm">
                        </div>
                    </div>
                    @endif

                    @if($pengaduan->teknisi)
                    <div class="text-xs text-gray-500">
                        <p>Diperbaiki oleh: <span class="font-medium text-gray-700">{{ $pengaduan->teknisi->name }}</span></p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Aksi Edit/Hapus -->
                @if($pengaduan->status === 'Menunggu')
                    <div class="pt-4 border-t border-gray-200 flex items-center justify-end gap-3">
                        <a href="{{ route('pengaduan.edit', $pengaduan->id) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50">
                            <span class="material-symbols-outlined text-base">edit</span>
                            Edit
                        </a>
                        <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" onsubmit="return confirm('Hapus pengaduan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700">
                                <span class="material-symbols-outlined text-base">delete</span>
                                Hapus
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Feedback Mahasiswa -->
                @if($pengaduan->status == 'Selesai')
                    <div class="pt-6 border-t border-gray-200 space-y-4">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-lg font-semibold text-gray-900">Feedback untuk Teknisi</h3>
                            @if($pengaduan->rating === null && !$pengaduan->feedback)
                                <a href="{{ route('mahasiswa.pengaduan.feedback', $pengaduan->id) }}" 
                                   class="inline-flex items-center gap-2 bg-primary hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors text-sm">
                                    Berikan Feedback
                                </a>
                            @endif
                        </div>
                        @if($pengaduan->rating === null)
                            <form method="POST" action="{{ route('pengaduan.feedback', $pengaduan->id) }}" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Penilaian (Rating Teknisi)</label>
                                    <div class="flex items-center gap-1">
                                        @for($i=1; $i<=5; $i++)
                                            <button type="button" onclick="document.getElementById('feedback-rating').value={{$i}};iberiBintang({{$i}})" id="star{{$i}}"
                                                class="focus:outline-none text-yellow-400">
                                                <span class="material-symbols-outlined text-3xl">star</span>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="feedback-rating" required>
                                    @error('rating')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tulis testimoni (opsional)</label>
                                    <textarea name="feedback" rows="3" maxlength="500"
                                        class="w-full rounded border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm"
                                        placeholder="Pendapat Anda tentang layanan teknisi...">{{ old('feedback') }}</textarea>
                                    @error('feedback')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
                                </div>
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">Kirim Feedback</button>
                            </form>
                            <script>
                                function iberiBintang(j) {
                                    for(let i=1;i<=5;i++){
                                        const el = document.getElementById('star'+i);
                                        el.children[0].style.color = i <= j ? '#FBBF24':'#E5E7EB';
                                    }
                                }
                            </script>
                        @else
                            <div class="border-t pt-4 mt-3">
                                <div class="flex items-center gap-1 text-yellow-500 text-xl font-bold mb-1">
                                    @for($i=1;$i<=5;$i++)
                                        <span class="material-symbols-outlined align-middle" style="font-size: 22px;line-height:1;">{{ $i <= $pengaduan->rating ? 'star' : 'star_half' }}</span>
                                    @endfor
                                    <span class="text-gray-600 ml-2 text-base font-medium">{{ number_format($pengaduan->rating, 1) }}</span>
                                </div>
                                @if($pengaduan->feedback)
                                    <blockquote class="italic text-gray-700 border-l-4 border-primary pl-4 mt-1">“{{ $pengaduan->feedback }}”</blockquote>
                                @else
                                    <p class="text-sm text-gray-600 mt-2">Tidak ada testimoni tertulis.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
</body>
</html>

