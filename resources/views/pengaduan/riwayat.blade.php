<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Riwayat Pengaduan</title>

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
                        <p class="text-sm font-medium">Dashboard</p>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary/10 text-primary"
                       href="{{ route('mahasiswa.riwayat') }}">
                        <span class="material-symbols-outlined text-primary">history</span>
                        <p class="text-sm font-medium">Riwayat Pengaduan</p>
                    </a>

                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10"
                       href="{{ route('mahasiswa.feedback.riwayat') }}">
                        <span class="material-symbols-outlined">star</span>
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
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Pengaduan</h1>
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

            @if(session('success'))
                <div class="bg-green-100 p-4 mb-4 rounded-lg text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full bg-white border rounded-lg">
                <thead class="border-b text-gray-500">
                <tr>
                    <th class="p-4 text-sm text-left font-medium">Subjek</th>
                    <th class="p-4 text-sm text-left font-medium">Tanggal</th>
                    <th class="p-4 text-sm text-left font-medium">Status</th>
                    <th class="p-4 text-sm text-left font-medium">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse($pengaduan as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 text-sm text-left">{{ $item->subjek }}</td>
                        <td class="p-4 text-sm text-left text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="p-4 text-sm text-left">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($item->status == 'Menunggu') bg-yellow-100 text-yellow-700
                                @elseif($item->status == 'Proses') bg-blue-100 text-blue-700
                                @else bg-green-100 text-green-700 @endif
                            ">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-left">
                            <a href="{{ route('mahasiswa.pengaduan.detail', $item->id) }}" class="text-blue-600 hover:text-blue-700 font-medium">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center p-5 text-gray-500">
                            Belum ada pengaduan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </section>

    </main>
</div>

</body>
</html>
