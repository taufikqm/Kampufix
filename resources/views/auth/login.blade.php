<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAMPUFIX</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#EDE4E2] min-h-screen flex items-center justify-center p-6">

<div class="bg-white w-full max-w-5xl rounded-3xl shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">

    {{-- BAGIAN KIRI --}}
    <div class="bg-[#F7F7F7] p-12 flex flex-col justify-center text-center">
        <h1 class="text-3xl md:text-3xl font-bold leading-snug">
            Fasilitas Terkelola,<br>
            Produktivitas Tanpa Batas.
        </h1>
        <p class="text-gray-600 md:text-1xl mt-4 font-semibold">
            Manajemen fasilitas menjadi lebih mudah dengan platform terpusat kami.
        </p>
    </div>

    {{-- BAGIAN KANAN --}}
    <div class="p-12">

        {{-- LOGO --}}

        <h2 class="text-3xl font-bold mb-2">Selamat Datang Kembali</h2>
        <p class="text-gray-600 font-semibold mb-8">Silakan masuk untuk melanjutkan</p>

        {{-- FORM LOGIN --}}
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Username / Email --}}
            <div>
                <label class="font-semibold">Nama Pengguna atau Email</label>
                <div class="flex items-center border rounded-lg mt-1 px-3 bg-gray-50">
                    <span class="text-gray-500"><i class="fa fa-user"></i></span>
                    <input type="text" name="email"
                           class="w-full p-3 bg-gray-50 focus:outline-none"
                           placeholder="Masukkan nama pengguna atau email Anda">
                </div>
            </div>

            {{-- Password --}}
            <div>
                <label class="font-semibold">Kata Sandi</label>
                <div class="flex items-center border rounded-lg mt-1 px-3 bg-gray-50">
                    <span class="text-gray-500"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password"
                           class="w-full p-3 bg-gray-50 focus:outline-none"
                           placeholder="Masukkan kata sandi Anda">
                    <span class="text-gray-500 cursor-pointer"><i class="fa fa-eye"></i></span>
                </div>
            </div>

            {{-- Lupa kata sandi --}}
            <div class="text-right">
                <a href="#" class="text-sm text-gray-500 hover:text-black">Lupa kata sandi?</a>
            </div>

            {{-- Tombol Login --}}
            <button 
                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg text-lg">
                Masuk
            </button>

        </form>
    </div>

</div>

{{-- Ikon FontAwesome (untuk icon user & lock) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

</body>
</html>
