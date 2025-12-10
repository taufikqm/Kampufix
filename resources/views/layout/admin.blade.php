<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet" />

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#dc2626",
                        "background-light": "#f9fafb",
                    },
                    fontFamily: { display: ["Inter", "sans-serif"] },
                }
            }
        }
    </script>
</head>

<body class="font-display">
    <div class="flex min-h-screen w-full">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white p-4 border-r border-gray-200">
            <div class="flex flex-col gap-4">

                <div class="flex gap-3 items-center p-2">
                    <div class="rounded-full size-10 bg-gray-200"></div>
                    <div>
                        <h1 class="text-gray-900 text-base font-medium">Admin Fasilitas</h1>
                        <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <nav class="flex flex-col gap-2 mt-4">

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-primary' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <p class="text-sm font-medium">Dashboard</p>
                    </a>

                    <a href="{{ route('admin.pengaduan') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.pengaduan*') ? 'bg-red-50 text-primary' : 'text-gray-600 hover:bg-gray-100' }}">
                        <span class="material-symbols-outlined">description</span>
                        <p class="text-sm font-medium">Pengaduan</p>
                    </a>

                </nav>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-100 w-full">
                        <span class="material-symbols-outlined">logout</span>
                        <p class="text-sm font-medium">Logout</p>
                    </button>
                </form>

            </div>
        </aside>

        <!-- HALAMAN CONTENT -->
        <main class="flex-1 p-8 bg-background-light">
            @yield('content')
        </main>

    </div>
</body>

</html>
