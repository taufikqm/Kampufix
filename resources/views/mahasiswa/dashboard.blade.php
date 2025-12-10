<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dasbor Pengaduan Fasilitas</title>

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

                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg
                        {{ request('tab') === null ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10' }}"
                       href="{{ route('mahasiswa.dashboard') }}">
                        <span class="material-symbols-outlined {{ request('tab')===null ? 'text-primary' : '' }}">dashboard</span>
                        <p class="text-sm font-medium">Dashboard</p>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg
                        {{ request('tab') === 'riwayat' ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10' }}"
                       href="{{ route('mahasiswa.dashboard', ['tab' => 'riwayat']) }}">
                        <span class="material-symbols-outlined {{ request('tab')==='riwayat' ? 'text-primary':'' }}">history</span>
                        <p class="text-sm font-medium">Riwayat Pengaduan</p>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('feedback*') ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10' }}"
                       href="{{ route('mahasiswa.feedback.riwayat') }}">
                        <span class="material-symbols-outlined {{ request()->is('feedback*') ? 'text-primary' : '' }}">star</span>
                        <p class="text-sm font-medium">Riwayat Feedback</p>
                    </a>

                </div>
            </div>

        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 flex flex-col">

        <header class="flex items-center justify-between px-8 py-6 border-b border-gray-100 bg-white">
            <div>
                <p class="text-sm text-gray-500 font-semibold">Portal Mahasiswa KampuFix</p>
                <h1 class="text-2xl font-bold text-gray-900">
                    @if(request('tab') === 'riwayat')
                        Riwayat Pengaduan
                    @else
                        Dashboard
                    @endif
                </h1>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-semibold">{{ Auth::user()->name ?? 'Mahasiswa KampuFix' }}</p>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'mahasiswa@kampufix.com' }}</p>
                    </div>
                <div class="h-12 w-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        <span class="material-symbols-outlined text-base">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <section class="p-8 flex-1">

            <!-- RIWAYAT PAGE -->
            @if(request('tab') === 'riwayat')

                <table class="w-full bg-white border rounded-lg">
                    <thead class="border-b text-gray-500">
                    <tr>
                        <th class="p-4 text-sm text-left font-medium">ID</th>
                        <th class="p-4 text-sm text-left font-medium">Subjek</th>
                        <th class="p-4 text-sm text-left font-medium">Tanggal</th>
                        <th class="p-4 text-sm text-left font-medium">Status</th>
                        <th class="p-4 text-sm text-left font-medium">Aksi</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($riwayat as $p)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 text-sm text-left font-medium text-primary">#{{ $p->id }}</td>
                            <td class="p-4 text-sm text-left">{{ $p->subjek }}</td>
                            <td class="p-4 text-sm text-left text-gray-500">{{ $p->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-sm text-left">
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($p->status === 'Menunggu') bg-yellow-100 text-yellow-700
                                @elseif($p->status === 'Selesai') bg-green-100 text-green-700
                                @else bg-blue-100 text-blue-700 @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                            </td>
                            <td class="p-4 text-sm text-left align-middle">
                                @if($p->status === 'Menunggu')
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('pengaduan.edit', $p->id) }}" class="inline-flex items-center justify-center w-5 h-5 text-gray-500 hover:text-gray-700 transition" title="Edit">
                                            <span class="material-symbols-outlined text-xl" style="line-height: 1; font-size: 20px;">edit</span>
                                        </a>
                                        <form action="{{ route('pengaduan.destroy', $p->id) }}" method="POST" class="inline-flex items-center" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-5 h-5 text-red-500 hover:text-red-700 transition" title="Hapus">
                                                <span class="material-symbols-outlined text-xl" style="line-height: 1; font-size: 20px;">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                @elseif($p->status === 'Selesai' && !$p->rating && !$p->feedback)
                                    <a href="{{ route('mahasiswa.pengaduan.feedback', $p->id) }}" class="text-green-600 hover:text-green-700 font-medium text-sm">Berikan Feedback</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            @else

                <h1 class="text-3xl font-black">Dasbor Pengaduan Saya</h1>

                <!-- STAT CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-6 bg-white border rounded-lg">
                        <p class="text-4xl font-bold">{{ $countPending }}</p>
                        <p class="text-base mt-1">Menunggu</p>
                    </div>

                    <div class="p-6 bg-white border rounded-lg">
                        <p class="text-4xl font-bold">{{ $countProcess }}</p>
                        <p class="text-base mt-1">Dalam Proses</p>
                    </div>

                    <div class="p-6 bg-white border rounded-lg">
                        <p class="text-4xl font-bold">{{ $countDone }}</p>
                        <p class="text-base mt-1">Selesai</p>
                    </div>
                </div>

                <!-- HERO BOX -->
                <div class="rounded-xl bg-primary/10 border p-6 flex items-center justify-between gap-6">

                    <!-- Gambar di kiri dengan ukuran responsif -->
                    <img src="{{ asset('images/fasilitas.png') }}" 
                        class="max-h-28 w-auto object-contain"
                        alt="Report Image">

                    <!-- Teks -->
                    <div class="flex-1">
                        <p class="text-2xl font-bold text-primary">Ada fasilitas bermasalah?</p>
                        <p class="text-gray-700">Laporkan kerusakan dengan cepat dan mudah.</p>
                    </div>

                    <!-- Tombol -->
                    <a href="{{ route('pengaduan.create') }}"
                    class="px-5 py-3 bg-primary text-white rounded-lg hover:bg-primary/80 shrink-0">
                        Buat Laporan Baru
                    </a>

                </div>



                <!-- RIWAYAT TERBARU (2 ITEM) -->
                <div class="bg-white border rounded-xl p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-primary">Riwayat Pengaduan Terbaru</h2>
                        <a href="{{ route('mahasiswa.dashboard', ['tab' => 'riwayat']) }}"
                           class="text-primary font-semibold hover:underline">Lihat Semua →</a>
                    </div>

                    @forelse($latestRiwayat as $item)
                        <div class="p-4 border rounded-lg mb-3 bg-gray-50">
                            <p class="font-semibold text-primary">{{ $item->subjek }}</p>
                            <p class="text-sm text-gray-600">{{ $item->created_at->format('d M Y') }}</p>
                            <p class="text-sm mt-1">{{ Str::limit($item->deskripsi, 100) }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Belum ada riwayat.</p>
                    @endforelse

                </div>

                <!-- HIGHLIGHT CARD -->
                <div class="rounded-xl bg-blue-50 border border-blue-200 p-6 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="material-symbols-outlined text-blue-600 text-5xl">history</span>
                        <div>
                            <p class="text-2xl font-bold text-blue-700">Riwayat Pengaduan</p>
                            <p class="text-blue-600">Lihat perkembangan laporan yang sudah kamu buat.</p>
                        </div>
                    </div>
                    <a href="{{ route('mahasiswa.dashboard', ['tab' => 'riwayat']) }}"
                       class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Lihat Semua →
                    </a>
                </div>

            @endif

        </section>

    </main>
</div>

</body>
</html>
