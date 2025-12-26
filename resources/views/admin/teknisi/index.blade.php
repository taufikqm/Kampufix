@extends('layouts.admin')

@section('page_title', 'Manajemen Teknisi')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Daftar Teknisi</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data teknisi dan status on duty</p>
            </div>
            <a href="{{ route('admin.teknisi.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                <span class="material-symbols-outlined text-lg">add</span>
                Tambah Teknisi
            </a>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter & Search -->
        <div class="bg-white rounded-xl border border-gray-100 p-4">
            <form method="GET" action="{{ route('admin.teknisi.index') }}" class="flex items-center gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama, email, atau nomor telepon..."
                           class="w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <select name="status" class="rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500">
                        <option value="">Semua Status</option>
                        <option value="on_duty" {{ request('status') === 'on_duty' ? 'selected' : '' }}>On Duty</option>
                        <option value="off_duty" {{ request('status') === 'off_duty' ? 'selected' : '' }}>Off Duty</option>
                    </select>
                </div>
                <button type="submit" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition">
                    <span class="material-symbols-outlined">search</span>
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.teknisi.index') }}" 
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesialisasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($teknisis as $index => $teknisi)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $teknisis->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900">{{ $teknisi->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $teknisi->email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $teknisi->phone ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $teknisi->specialization ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.teknisi.toggle-duty', $teknisi->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="px-3 py-1 rounded-full text-xs font-medium transition
                                            {{ $teknisi->on_duty 
                                                ? 'bg-green-100 text-green-700 hover:bg-green-200' 
                                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                        {{ $teknisi->on_duty ? 'On Duty' : 'Off Duty' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.teknisi.edit', $teknisi->id) }}"
                                       class="text-gray-500 hover:text-gray-700 transition" title="Edit">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </a>
                                    <form action="{{ route('admin.teknisi.destroy', $teknisi->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus teknisi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-500 hover:text-red-700 transition" 
                                                title="Hapus">
                                            <span class="material-symbols-outlined text-xl">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Belum ada teknisi. <a href="{{ route('admin.teknisi.create') }}" class="text-red-600 hover:underline">Tambah teknisi pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($teknisis->hasPages())
            <div class="mt-4">
                {{ $teknisis->links() }}
            </div>
        @endif
    </div>
@endsection

