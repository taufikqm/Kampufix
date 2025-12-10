@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Daftar Pengaduan</h1>

<div class="bg-white p-6 rounded-xl border border-gray-200">
    <table class="w-full text-left">
        <thead>
            <tr class="text-gray-500 border-b">
                <th class="py-3">ID</th>
                <th>Nama</th>
                <th>Subjek</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pengaduan as $p)
            <tr class="border-b">
                <td class="py-3">{{ $p->id }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->subjek }}</td>
                <td>
                    <span class="px-3 py-1 rounded-full
                        {{ $p->status === 'Diproses' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $p->status === 'Selesai'  ? 'bg-green-100 text-green-700'  : '' }}
                        {{ $p->status === 'Menunggu' ? 'bg-gray-100 text-gray-700'   : '' }}">
                        {{ $p->status }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.pengaduan.detail', $p->id) }}" class="text-primary">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection
