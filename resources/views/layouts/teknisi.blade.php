<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KampuFix | Teknisi</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body {
            font-family: "Lexend", "Inter", sans-serif;
        }
    </style>
</head>
<body class="bg-[#F7F7F9] min-h-screen text-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 bg-white border-r border-gray-100 flex flex-col">
            <div class="px-6 py-8 space-y-8">
                <!-- Logo & Nama KampuFix -->
                <div class="flex items-center gap-3 text-red-600">
                    <svg class="h-8 w-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 2a8 8 0 100 16 8 8 0 000-16zM8.707 14.707a1 1 0 001.414 0L14 10.828V12a1 1 0 102 0V8a1 1 0 00-1-1h-4a1 1 0 100 2h1.172L8.707 12.293a1 1 0 000 1.414zM6 6a1 1 0 100 2h4a1 1 0 100-2H6z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-bold text-red-600">KampuFix</h2>
                </div>

                @php
                    $navItems = [
                        ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'teknisi.dashboard'],
                        ['label' => 'Tugas Saya', 'icon' => 'assignment', 'route' => 'teknisi.tasks'],
                        ['label' => 'Feedback', 'icon' => 'star', 'route' => 'teknisi.feedback'],
                    ];
                @endphp

                <nav class="space-y-1">
                    @foreach ($navItems as $item)
                        @php
                            $isActive = $item['route'] ? request()->routeIs($item['route']) : false;
                            $url = $item['route'] && \Illuminate\Support\Facades\Route::has($item['route'])
                                ? route($item['route'])
                                : '#';
                        @endphp
                        <a href="{{ $url }}"
                           class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
                           {{ $isActive ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="material-symbols-outlined text-base">{{ $item['icon'] }}</span>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="px-6 py-6 mt-auto">
                <div class="rounded-2xl bg-red-50 p-4">
                    <p class="text-sm font-semibold text-red-600">Butuh Bantuan?</p>
                    <p class="text-xs text-red-500 mt-1">Hubungi tim support kami kapan saja.</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <header class="flex items-center justify-between px-8 py-6 border-b border-gray-100 bg-white">
                <div>
                    <p class="text-sm text-gray-500">Portal Teknisi KampuFix</p>
                    <h1 class="text-2xl font-semibold text-gray-900">@yield('page_title', 'Dasbor')</h1>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="font-semibold">{{ Auth::user()->name ?? 'Teknisi KampuFix' }}</p>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'teknisi@kampufix.com' }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-semibold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'T', 0, 1)) }}
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
                @yield('content')
            </section>
        </main>
    </div>

    @stack('scripts')
    @yield('scripts')
</body>
</html>

