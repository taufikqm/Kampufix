<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Feedback Laporan - KampuFix</title>
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
        <header class="flex items-center justify-end border-b px-10 py-3 bg-white">
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-semibold">{{ Auth::user()->name ?? 'Mahasiswa KampuFix' }}</p>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'mahasiswa@kampufix.com' }}</p>
                </div>
                <div class="h-12 w-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr(Auth::user()->name ?? 'M', 0, 1)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        <span class="material-symbols-outlined text-base">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="p-8 space-y-6">
            <div>
                <p class="text-sm text-gray-500 font-semibold mb-1">Portal Mahasiswa KampuFix</p>
                <h1 class="text-3xl font-bold text-gray-900">Feedback Laporan</h1>
            </div>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Detail Pengaduan Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-primary">{{ $pengaduan->subjek }}</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                        Selesai
                    </span>
                </div>
                <p class="text-sm text-gray-600">Dilaporkan pada: {{ $pengaduan->created_at->translatedFormat('d M Y') }}</p>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $pengaduan->deskripsi }}</p>
                </div>
            </div>

            <!-- Feedback Form Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-6">
                <h3 class="text-lg font-bold text-gray-900">Berikan Ulasan Anda</h3>
                
                <form method="POST" action="{{ route('pengaduan.feedback', $pengaduan->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-3">Bagaimana penilaian Anda terhadap penanganan laporan ini?</p>
                        <div class="flex items-center gap-2" id="rating-container">
                            @for($i=1; $i<=5; $i++)
                                <button type="button" 
                                        onclick="setRating({{$i}})" 
                                        id="star{{$i}}"
                                        class="focus:outline-none transition-colors">
                                    <span class="material-symbols-outlined text-4xl text-gray-300">star</span>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" required>
                        @error('rating')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">Komentar (Opsional)</label>
                        <textarea name="feedback" 
                                  id="feedback" 
                                  rows="6"
                                  maxlength="500"
                                  class="w-full rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 px-4 py-3 text-sm resize-none"
                                  placeholder="Tuliskan komentar Anda di sini...">{{ old('feedback') }}</textarea>
                        @error('feedback')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-primary hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors">
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
    let selectedRating = 0;

    function setRating(rating) {
        selectedRating = rating;
        document.getElementById('rating-input').value = rating;
        
        // Update star display
        for(let i = 1; i <= 5; i++) {
            const star = document.getElementById('star' + i);
            const icon = star.querySelector('.material-symbols-outlined');
            if (i <= rating) {
                icon.textContent = 'star';
                icon.classList.remove('text-gray-300');
                icon.classList.add('text-yellow-400');
            } else {
                icon.textContent = 'star';
                icon.classList.remove('text-yellow-400');
                icon.classList.add('text-gray-300');
            }
        }
    }

    // Hover effect untuk stars
    document.addEventListener('DOMContentLoaded', function() {
        for(let i = 1; i <= 5; i++) {
            const star = document.getElementById('star' + i);
            star.addEventListener('mouseenter', function() {
                for(let j = 1; j <= i; j++) {
                    const hoverStar = document.getElementById('star' + j);
                    const hoverIcon = hoverStar.querySelector('.material-symbols-outlined');
                    if (!hoverIcon.classList.contains('text-yellow-400')) {
                        hoverIcon.classList.add('text-yellow-300');
                    }
                }
            });
            star.addEventListener('mouseleave', function() {
                for(let j = 1; j <= 5; j++) {
                    const hoverStar = document.getElementById('star' + j);
                    const hoverIcon = hoverStar.querySelector('.material-symbols-outlined');
                    if (j > selectedRating) {
                        hoverIcon.classList.remove('text-yellow-300');
                    }
                }
            });
        }
    });
</script>
</body>
</html>

