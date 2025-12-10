<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Riwayat Feedback - KampuFix</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                    <span class="material-symbols-outlined text-3xl text-primary">apartment</span>
                    <h2 class="text-xl font-bold text-primary">KampuFix</h2>
                </div>
                <div class="flex flex-col gap-2 mt-3">
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('dashboard') ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10' }}" href="{{ route('mahasiswa.dashboard') }}">
                        <span class="material-symbols-outlined {{ request()->is('dashboard') ? 'text-primary' : '' }}">dashboard</span>
                        <p class="text-sm font-medium">Dashboard</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('dashboard/riwayat') ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10' }}" href="{{ route('mahasiswa.riwayat') }}">
                        <span class="material-symbols-outlined {{ request()->is('dashboard/riwayat') ? 'text-primary' : '' }}">history</span>
                        <p class="text-sm font-medium">Riwayat Pengaduan</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('feedback*') ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10' }}" href="{{ route('mahasiswa.feedback.riwayat') }}">
                        <span class="material-symbols-outlined {{ request()->is('feedback*') ? 'text-primary' : '' }}">star</span>
                        <p class="text-sm font-medium">Riwayat Feedback</p>
                    </a>
                </div>
            </div>
            <div class="mt-auto px-3 py-3 text-xs text-primary bg-primary/10 rounded-lg">Butuh Bantuan? Hubungi tim support kami kapan saja.</div>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="flex-1 flex flex-col">
        <header class="bg-white border-b border-gray-100 px-8 py-6 flex items-center justify-between">
            <div class="font-semibold">
                <p class="text-sm text-gray-500">Portal Mahasiswa KampuFix</p>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Feedback Anda</h1>
                <p class="text-gray-500 text-sm mt-2">Tinjau semua umpan balik yang telah Anda berikan untuk laporan yang sudah selesai.</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-semibold">{{ Auth::user()->name ?? 'Mahasiswa KampuFix' }}</p>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'mahasiswa@kampufix.com' }}</p>
                </div>
                <div class="h-12 w-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        <span class="material-symbols-outlined text-base">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <div class="p-8 space-y-6 max-w-3xl mx-auto">
            @if($feedback->count() == 0)
                <div class="bg-white border rounded-xl p-8 text-gray-400 text-center">Belum ada feedback yang pernah Anda berikan.</div>
            @else
                @foreach($feedback as $f)
                    <div class="bg-white border rounded-xl p-6 shadow-sm flex flex-col gap-2">
                        <div class="flex flex-row items-center justify-between gap-4 flex-wrap">
                            <div>
                                <div class="font-semibold text-gray-900 text-base mb-0.5">Pengaduan #{{ $f->kode ?? $f->id }}: {{ $f->subjek }}</div>
                                <div class="text-sm text-gray-500">Ditangani oleh: <span class="font-medium text-gray-700">{{ $f->teknisi->name ?? '-' }}</span></div>
                            </div>
                            <div class="flex items-center gap-1 min-w-[120px] justify-end">
                                @for($i=1;$i<=5;$i++)
                                    <span class="material-symbols-outlined align-middle text-yellow-400 text-xl" style="font-size: 22px;line-height:1;">{{ $i <= $f->rating ? 'star' : 'star_border' }}</span>
                                @endfor
                                @if($f->rating)
                                    <span class="text-gray-700 ml-2 text-base font-medium">{{ number_format($f->rating, 1) }}</span>
                                @endif
                            </div>
                        </div>
                        @if($f->feedback)
                            <blockquote class="italic text-gray-700 border-l-4 border-primary/60 pl-4 mt-1">“{{ $f->feedback }}”</blockquote>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </main>
</div>
</body>
</html>
