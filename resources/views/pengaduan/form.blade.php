<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan</title>

    <!-- TAILWIND CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CUSTOM WARNA PRIMARY -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#D93025", // WARNA MERAH BRAND KAMU
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">

{{-- NAVBAR --}}
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">

        <div class="flex items-center gap-4 px-3">
            <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M10 2a8 8 0 100 16 8 8 0 000-16zM8.707 14.707a1 1 0 001.414 0L14 10.828V12a1 1 0 102 0V8a1 1 0 00-1-1h-4a1 1 0 100 2h1.172L8.707 12.293a1 1 0 000 1.414zM6 6a1 1 0 100 2h4a1 1 0 100-2H6z">
                </path>
            </svg>
            <h2 class="text-xl font-bold text-primary">KampuFix</h2>
        </div>

        <div class="flex items-center space-x-8">
            <a href="/" class="text-gray-700 hover:text-black font-semibold">Beranda</a>
            <a href="/status" class="text-gray-700 hover:text-black font-semibold">Status Pengaduan</a>

            <a href="{{ route('login') }}"  
               class="bg-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-primary/80">
               Login
            </a>
        </div>

    </div>
</nav>

{{-- FORM --}}
<div class="container mx-auto py-10 max-w-3xl">
    @if(session('success'))
        <div class="bg-green-100 p-4 rounded mb-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold">Ada Masalah? Kami Siap Membantu</h1>
        <p class="text-gray-600 mt-2 font-semibold">
            Silakan isi detail di bawah ini dan tim kami akan menindaklanjutinya.
        </p>
    </div>

    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow-md rounded-lg p-8">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
            <div>
                <label class="font-bold">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border rounded  p-3 mt-1" placeholder="Masukkan nama lengkap">
            </div>

            <div>
                <label class="font-bold">NIM</label>
                <input type="text" name="nim" class="w-full border rounded p-3 mt-1" placeholder="Masukkan NIM Anda">
            </div>
        </div>

        <div class="mb-5">
            <label class="font-bold">Alamat Email</label>
            <input type="email" name="email" class="w-full border rounded p-3 mt-1" placeholder="contoh@email.com">
        </div>

        <div class="mb-5">
            <label class="font-bold">Subjek Pengaduan</label>
            <input type="text" name="subjek" class="w-full border rounded p-3 mt-1" placeholder="Masukkan subjek pengaduan Anda">
        </div>

        <div class="mb-5">
            <label class="font-bold">Upload Foto (Opsional)</label>
            <div class="border border-dashed rounded p-6 text-center text-gray-500 mt-2">
                <input type="file" name="foto" class="w-full cursor-pointer">
                <p class="text-sm mt-2">SVG, PNG, JPG, GIF (Max. 800×400px)</p>
            </div>
        </div>

        <div class="mb-5">
            <label class="font-bold">Deskripsi Lengkap</label>
            <textarea name="deskripsi" rows="4" class="w-full border rounded p-3 mt-1"
            placeholder="Jelaskan masalah Anda secara detail..."></textarea>
        </div>

        <button type="submit" class="w-full bg-primary text-white p-3 rounded text-lg font-bold hover:bg-primary/80">
            Kirim Pengaduan
        </button>
    </form>
</div>

</body>
</html>
