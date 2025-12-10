@extends('layouts.admin')

@section('page_title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">
        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Pengaduan Baru -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Pengaduan Baru</h3>
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-red-600">add_alert</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $pengaduanBaru }}</p>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium {{ $persentaseBaru['isPositive'] ? 'text-green-600' : 'text-red-600' }}">
                        {{ $persentaseBaru['isPositive'] ? '+' : '-' }}{{ $persentaseBaru['value'] }}%
                    </span>
                    <span class="text-xs text-gray-500">dari minggu lalu</span>
                </div>
            </div>

            <!-- Pengaduan Dalam Proses -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Pengaduan Dalam Proses</h3>
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-orange-600">sync</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $pengaduanDiproses }}</p>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium {{ $persentaseDiproses['isPositive'] ? 'text-green-600' : 'text-red-600' }}">
                        {{ $persentaseDiproses['isPositive'] ? '+' : '-' }}{{ $persentaseDiproses['value'] }}%
                    </span>
                    <span class="text-xs text-gray-500">dari minggu lalu</span>
                </div>
            </div>

            <!-- Pengaduan Selesai -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Pengaduan Selesai</h3>
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $pengaduanSelesai }}</p>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium {{ $persentaseSelesai['isPositive'] ? 'text-green-600' : 'text-red-600' }}">
                        {{ $persentaseSelesai['isPositive'] ? '+' : '-' }}{{ $persentaseSelesai['value'] }}%
                    </span>
                    <span class="text-xs text-gray-500">dari minggu lalu</span>
                </div>
            </div>

            <!-- Total User Aktif -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Total User Aktif</h3>
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600">people</span>
                    </div>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $totalUserAktif }}</p>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium {{ $persentaseUser['isPositive'] ? 'text-green-600' : 'text-red-600' }}">
                        {{ $persentaseUser['isPositive'] ? '+' : '-' }}{{ $persentaseUser['value'] }}%
                    </span>
                    <span class="text-xs text-gray-500">dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Grafik Pengaduan Bulanan -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Grafik Pengaduan Bulanan</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-900">{{ array_sum(array_column($chartData, 'total')) }}</p>
                        <p class="text-sm font-medium text-green-600">+15.2%</p>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <!-- Status Pengaduan (Donut Chart) -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex flex-col">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pengaduan</h3>
                <div class="flex-1 flex items-center justify-center mb-6">
                    <div class="relative w-48 h-48">
                        <canvas id="donutChart"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900">{{ $pengaduanBaru + $pengaduanDiproses + $pengaduanSelesai }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-sm text-gray-600">Baru</span>
                        </div>
                        <span class="text-sm font-semibold text-red-600">{{ $pengaduanBaru }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                            <span class="text-sm text-gray-600">Proses</span>
                        </div>
                        <span class="text-sm font-semibold text-orange-600">{{ $pengaduanDiproses }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                            <span class="text-sm text-gray-600">Selesai</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">{{ $pengaduanSelesai }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID LAPORAN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PELAPOR</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TANGGAL</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($aktivitasTerbaru as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-900">{{ $item->kode ?? '#CF-' . str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $item->nama }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ $item->created_at->translatedFormat('d M Y') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($item->status === 'Selesai') bg-green-100 text-green-700
                                        @elseif($item->status === 'Diproses' || $item->status === 'Proses') bg-orange-100 text-orange-700
                                        @elseif($item->status === 'Baru') bg-red-100 text-red-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada aktivitas untuk ditampilkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Bar Chart
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($chartData, 'bulan')) !!},
                datasets: [{
                    label: 'Pengaduan',
                    data: {!! json_encode(array_column($chartData, 'total')) !!},
                    backgroundColor: function(context) {
                        const index = context.dataIndex;
                        const total = {!! json_encode(array_column($chartData, 'total')) !!};
                        // Highlight bulan terakhir dengan warna lebih gelap
                        return index === total.length - 1 ? '#dc2626' : '#fca5a5';
                    },
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 40,
                    maxBarThickness: 50,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10,
                        left: 10,
                        right: 10
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: '#f3f4f6',
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 11
                            },
                            color: '#6b7280'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#6b7280'
                        }
                    }
                }
            }
        });

        // Donut Chart
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Baru', 'Proses', 'Selesai'],
                datasets: [{
                    data: [{{ $pengaduanBaru }}, {{ $pengaduanDiproses }}, {{ $pengaduanSelesai }}],
                    backgroundColor: ['#ef4444', '#f97316', '#9ca3af'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    </script>
@endsection
