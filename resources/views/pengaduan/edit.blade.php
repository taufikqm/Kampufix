<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Pengaduan - KampuFix</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#D93025",
                        "background-light": "#FAFAFA",
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
<body class="font-display bg-background-light">
<div class="flex min-h-screen">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r">
        <div class="p-4 flex flex-col h-full justify-between">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-3 text-primary px-3">
                    <h2 class="text-xl font-bold text-primary">KampuFix</h2>
                </div>
                <div class="flex flex-col gap-2">
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10"
                       href="{{ route('mahasiswa.dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <p class="text-sm font-medium">Dashboard</p>
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
    <main class="flex-1 flex flex-col">
        <header class="flex items-center justify-between border-b px-10 py-4 bg-white">
            <div>
                <p class="text-sm text-gray-500 font-semibold">Portal Mahasiswa KampuFix</p>
                <h1 class="text-2xl font-bold text-gray-900">Edit Pengaduan</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-semibold">{{ Auth::user()->name ?? 'Mahasiswa KampuFix' }}</p>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'mahasiswa@kampufix.com' }}</p>
                </div>
                <div class="h-12 w-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="p-8 space-y-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">ID Pengaduan: {{ $pengaduan->kode ?? '#'.str_pad($pengaduan->id, 4, '0', STR_PAD_LEFT) }}</p>
                        <h2 class="text-xl font-bold text-primary mt-1">{{ $pengaduan->subjek }}</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">
                        Menunggu
                    </span>
                </div>

                <form method="POST" action="{{ route('pengaduan.update', $pengaduan->id) }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subjek Pengaduan</label>
                            <input type="text" name="subjek" value="{{ old('subjek', $pengaduan->subjek) }}"
                                   class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 px-4 py-3 text-sm" required>
                            @error('subjek')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $pengaduan->lokasi) }}"
                                   class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 px-4 py-3 text-sm">
                            @error('lokasi')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="6"
                                  class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 px-4 py-3 text-sm resize-none"
                                  required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                        @error('deskripsi')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Foto (Opsional)</label>
                        @if($pengaduan->foto)
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/'.$pengaduan->foto) }}" alt="Foto pengaduan" class="h-16 w-16 object-cover rounded-lg border border-gray-200">
                                <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengganti.</p>
                            </div>
                        @endif
                        <input type="file" name="foto" class="w-full text-sm" accept="image/png,image/jpeg">
                        @error('foto')<div class="text-red-600 text-xs mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('mahasiswa.pengaduan.detail', $pengaduan->id) }}"
                           class="inline-flex items-center gap-2 px-5 py-3 rounded-lg border border-gray-300 text-gray-700 text-sm font-semibold hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-3 rounded-lg bg-primary text-white text-sm font-semibold hover:bg-red-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>

