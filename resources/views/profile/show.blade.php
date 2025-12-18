<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Profil Saya - KampuFix</title>
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
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <style>
        .material-symbols-outlined { font-variation-settings:'FILL' 1,'wght' 400,'GRAD' 0,'opsz' 24 }
    </style>
</head>
<body class="font-display bg-background-light">

<div class="flex min-h-screen">
    <!-- SIDEBAR (Copy from Dashboard) -->
    <aside class="w-64 bg-white border-r">
        <div class="p-4 flex flex-col h-full justify-between">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-3 text-primary px-3">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM8.707 14.707a1 1 0 001.414 0L14 10.828V12a1 1 0 102 0V8a1 1 0 00-1-1h-4a1 1 0 100 2h1.172L8.707 12.293a1 1 0 000 1.414zM6 6a1 1 0 100 2h4a1 1 0 100-2H6z"></path>
                    </svg>
                    <h2 class="text-xl font-bold text-primary">KampuFix</h2>
                </div>
                <div class="flex flex-col gap-2">
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10" href="{{ route('mahasiswa.dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <p class="text-sm font-medium">Dashboard</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10" href="{{ route('mahasiswa.dashboard', ['tab' => 'riwayat']) }}">
                        <span class="material-symbols-outlined">history</span>
                        <p class="text-sm font-medium">Riwayat Pengaduan</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-primary/10" href="{{ route('mahasiswa.feedback.riwayat') }}">
                        <span class="material-symbols-outlined">star</span>
                        <p class="text-sm font-medium">Riwayat Feedback</p>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->is('profile*') ? 'bg-primary/10 text-primary' : 'hover:bg-primary/10' }}" href="{{ route('profile.show') }}">
                        <span class="material-symbols-outlined {{ request()->is('profile*') ? 'text-primary' : '' }}">person</span>
                        <p class="text-sm font-medium">Profil Saya</p>
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col">
        <header class="flex items-center justify-between px-8 py-6 border-b border-gray-100 bg-white">
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Profil</h1>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-semibold">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
                <!-- Avatar -->
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="h-12 w-12 rounded-full object-cover border border-gray-200">
                @else
                    <div class="h-12 w-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
        </header>

        <section class="p-8 max-w-4xl">
            @if(session('success'))
                <div class="bg-green-100 p-4 mb-6 rounded-lg text-green-700 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 p-4 mb-6 rounded-lg text-red-700 border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center shadow-sm">
                        <div class="relative inline-block mb-4">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="h-32 w-32 rounded-full object-cover border-4 border-gray-50">
                            @else
                                <div class="h-32 w-32 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto text-4xl font-bold border-4 border-gray-50">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm mb-4">{{ ucfirst($user->role) }}</p>

                        @if($user->profile_photo_path)
                            <form action="{{ route('profile.photo.destroy') }}" method="POST" onsubmit="return confirm('Hapus foto profil?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium hover:underline">
                                    Hapus Foto
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Biodata</h3>
                        
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <!-- Foto Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto Profil</label>
                                <input type="file" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg cursor-pointer">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maks 2MB.</p>
                            </div>

                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('name') border-red-500 @enderror" required>
                                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 @error('email') border-red-500 @enderror" required>
                                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <hr class="my-6 border-gray-200">

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Opsional)</label>
                                <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" placeholder="Kosongkan jika tidak ingin mengubah">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500">
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
