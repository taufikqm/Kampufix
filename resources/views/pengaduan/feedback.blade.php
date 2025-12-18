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

            <!-- Detail Pengaduan Card (Read Only) -->
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Ringkasan Laporan Anda</span>
                        <h2 class="text-lg font-bold text-gray-900 mt-1">{{ $pengaduan->subjek }}</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                        Selesai
                    </span>
                </div>
                <div class="text-sm text-gray-600">
                    Dilaporkan pada: {{ $pengaduan->created_at->translatedFormat('d F Y') }}
                </div>
                <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $pengaduan->deskripsi }}</p>
                </div>
            </div>

            <!-- Feedback Form Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-6 shadow-sm">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Berikan Ulasan & Feedback</h3>
                    <p class="text-gray-500 text-sm mt-1">Bantu kami meningkatkan kualitas layanan KampuFix</p>
                </div>
                
                <form method="POST" action="{{ route('pengaduan.feedback', $pengaduan->id) }}" class="space-y-6" id="feedbackForm">
                    @csrf
                    @method('PATCH')
                    
                    <div class="bg-yellow-50/50 p-6 rounded-xl border border-yellow-100 text-center">
                        <p class="text-base font-medium text-gray-800 mb-4">Seberapa puas Anda dengan hasil perbaikan ini?</p>
                        
                        <div class="flex justify-center items-center gap-3 mb-2" id="rating-container">
                            @for($i=1; $i<=5; $i++)
                                <button type="button" 
                                        onclick="setRating({{$i}})" 
                                        onmouseenter="hoverRating({{$i}})"
                                        onmouseleave="resetHover()"
                                        id="star{{$i}}"
                                        class="focus:outline-none transition-transform hover:scale-110 p-1">
                                    <span class="material-symbols-outlined text-5xl text-gray-300 transition-colors duration-200">star</span>
                                </button>
                            @endfor
                        </div>
                        <p id="rating-text" class="text-sm font-medium text-gray-500 h-5"></p>

                        <input type="hidden" name="rating" id="rating-input" required autocomplete="off">
                        @error('rating')
                            <div class="text-red-600 text-sm mt-2 font-medium bg-red-50 py-1 px-3 rounded inline-block">{{ $message }}</div>
                        @enderror
                        <div id="rating-error" class="hidden text-red-600 text-sm mt-2 font-medium bg-red-50 py-1 px-3 rounded inline-block">Silakan pilih rating bintang terlebih dahulu</div>
                    </div>

                    <div>
                        <label for="feedback" class="block text-sm font-semibold text-gray-700 mb-2">Ceritakan pengalaman Anda (Opsional)</label>
                        <textarea name="feedback" 
                                  id="feedback" 
                                  rows="4"
                                  maxlength="500"
                                  class="w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm"
                                  placeholder="Contoh: Teknisi datang tepat waktu, perbaikan sangat rapi, dan ramah...">{{ old('feedback') }}</textarea>
                        @error('feedback')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" 
                                onclick="return validateForm()"
                                class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-md hover:shadow-lg transform active:scale-95">
                            <span class="material-symbols-outlined">send</span>
                            Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
    let currentRating = 0;
    const ratingTexts = [
        '',
        'Sangat Kecewa 😞',
        'Kurang Puas 🙁',
        'Cukup Puas 😐',
        'Puas 🙂',
        'Sangat Puas! 🤩'
    ];

    function updateStars(rating) {
        for(let i = 1; i <= 5; i++) {
            const starIcon = document.querySelector(`#star${i} span`);
            if (i <= rating) {
                starIcon.classList.remove('text-gray-300');
                starIcon.classList.add('text-yellow-400', 'fill-current');
                // Google Material Symbols 'FILL' variation logic if needed via class or style
                starIcon.style.fontVariationSettings = "'FILL' 1";
            } else {
                starIcon.classList.remove('text-yellow-400', 'fill-current');
                starIcon.classList.add('text-gray-300');
                starIcon.style.fontVariationSettings = "'FILL' 0";
            }
        }
        
        const textEl = document.getElementById('rating-text');
        if(rating > 0) {
            textEl.textContent = ratingTexts[rating];
            textEl.classList.add('text-yellow-600');
        } else {
            textEl.textContent = '';
        }
    }

    function setRating(rating) {
        currentRating = rating;
        document.getElementById('rating-input').value = rating;
        document.getElementById('rating-error').classList.add('hidden');
        updateStars(rating);
    }

    function hoverRating(rating) {
        updateStars(rating);
    }

    function resetHover() {
        updateStars(currentRating);
    }

    function validateForm() {
        if (currentRating === 0) {
            document.getElementById('rating-error').classList.remove('hidden');
            return false;
        }
        return true;
    }
</script>
</body>
</html>

