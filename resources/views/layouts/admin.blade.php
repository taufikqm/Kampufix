<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampuFix | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: "Lexend", "Inter", sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r flex flex-col">
            <div class="p-4 flex flex-col h-full justify-between">
                <div class="flex flex-col gap-6">
                    <!-- Logo KampuFix -->
                    <div class="flex items-center gap-3 text-red-600 px-3">
                        <svg class="h-8 w-8" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="10" cy="10" r="8" fill="#dc2626"/>
                            <path d="M7 7l6 6M13 7l-6 6" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 7h-3v3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <h2 class="text-xl font-bold text-red-600">KampuFix</h2>
                            <p class="text-xs text-gray-500">Admin Panel</p>
                        </div>
                    </div>

                @php
                    $isPengaduanActive = request()->routeIs('admin.pengaduan.*');
                @endphp

                <nav class="flex flex-col gap-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                       {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-red-50' }}">
                        <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'text-red-600' : '' }}">dashboard</span>
                        <p class="text-sm font-medium">Dashboard</p>
                    </a>

                    <!-- Pengaduan dengan dropdown -->
                    <div>
                        <button onclick="togglePengaduanMenu()" 
                                class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-lg text-sm font-medium
                                {{ $isPengaduanActive ? 'bg-red-50 text-red-600' : 'text-gray-600 hover:bg-red-50' }}">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined {{ $isPengaduanActive ? 'text-red-600' : '' }}">assignment</span>
                                <p class="text-sm font-medium">Pengaduan</p>
                            </div>
                            <span class="material-symbols-outlined transition-transform" id="pengaduanArrow">expand_more</span>
                        </button>
                        <div id="pengaduanMenu" class="{{ $isPengaduanActive ? 'block' : 'hidden' }} pl-11 mt-1 space-y-1">
                            <a href="{{ route('admin.pengaduan.index') }}"
                               class="block px-3 py-2 rounded-lg text-sm
                               {{ request()->routeIs('admin.pengaduan.index') ? 'text-red-600 font-medium bg-red-50' : 'text-gray-600 hover:bg-red-50' }}">
                                Semua Pengaduan
                            </a>
                            <a href="#"
                               class="block px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-red-50">
                                Detail Pengaduan
                            </a>
                            <a href="{{ route('admin.kategori.index') }}"
                               class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.kategori.*') ? 'text-red-600 font-medium bg-red-50' : 'text-gray-600 hover:bg-red-50' }}">
                                Kategori
                            </a>
                        </div>
                    </div>

                    <!-- Menu lainnya -->
                    <a href="{{ route('admin.feedback.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.feedback.index') ? 'text-red-600 bg-red-50' : 'text-gray-600 hover:bg-red-50' }}">
                        <span class="material-symbols-outlined">feedback</span>
                        <p class="text-sm font-medium">Feedback Pengguna</p>
                    </a>
                </nav>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Header Bar -->
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">@yield('page_title', 'Dashboard Admin')</h1>
                    <div class="flex items-center gap-4">
                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Search..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg">search</span>
                        </div>
                        
                        <!-- Notification Icon -->
                        <button class="relative p-2 rounded-lg hover:bg-gray-100 transition">
                            <span class="material-symbols-outlined text-gray-600">notifications</span>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- User Profile -->
                        <div class="h-10 w-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-semibold cursor-pointer hover:bg-red-200 transition">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                                <span class="material-symbols-outlined text-base">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content Section -->
            <section class="p-8 flex-1 overflow-y-auto">
                @yield('content')
            </section>
        </main>
    </div>

    <script>
        function togglePengaduanMenu() {
            const menu = document.getElementById('pengaduanMenu');
            const arrow = document.getElementById('pengaduanArrow');
            menu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }
    </script>
</body>
</html>
