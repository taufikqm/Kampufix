<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pengaduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-10">

<h1 class="text-3xl font-bold mb-6">Riwayat Pengaduan Anda</h1>

@if(session('success'))
    <div class="bg-green-100 p-4 mb-4 rounded text-green-700">
        {{ session('success') }}
    </div>
@endif

<table class="w-full bg-white shadow rounded-lg overflow-hidden">
    <thead class="bg-gray-50 border-b">
        <tr>
            <th class="p-3 text-left">Subjek</th>
            <th class="p-3 text-left">Tanggal</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pengaduan as $item)
            <tr class="border-b">
                <td class="p-3">{{ $item->subjek }}</td>
                <td class="p-3">{{ $item->created_at->format('d M Y') }}</td>
                <td class="p-3">
                    <span class="px-3 py-1 rounded text-sm
                        @if($item->status == 'Menunggu') bg-yellow-100 text-yellow-700
                        @elseif($item->status == 'Proses') bg-blue-100 text-blue-700
                        @else bg-green-100 text-green-700 @endif
                    ">
                        {{ $item->status }}
                    </span>
                </td>

                <td class="p-3">
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

</body>
</html>
