<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalPengaduan = Pengaduan::count();
        $pengaduanBaru = Pengaduan::where('status', 'Baru')->count();
        $pengaduanDiproses = Pengaduan::where('status', 'Diproses')->count();
        $pengaduanSelesai = Pengaduan::where('status', 'Selesai')->count();
        $totalUserAktif = User::where('role', '!=', 'admin')->count();

        // Data grafik bulanan (6 bulan terakhir)
        $bulanan = Pengaduan::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
        ->groupBy('bulan', 'tahun')
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

        // Format data untuk chart
        $chartData = [];
        $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulan = $date->month;
            $tahun = $date->year;
            
            $data = $bulanan->firstWhere(function($item) use ($bulan, $tahun) {
                return $item->bulan == $bulan && $item->tahun == $tahun;
            });
            
            $chartData[] = [
                'bulan' => $bulanNama[$bulan - 1],
                'total' => $data ? $data->total : 0
            ];
        }

        // Aktivitas terbaru (5 pengaduan terakhir)
        $aktivitasTerbaru = Pengaduan::latest()->take(5)->get();

        // Hitung persentase perubahan (dummy untuk sekarang, bisa dihitung dari data historis)
        $persentaseBaru = $this->calculatePercentageChange('Baru');
        $persentaseDiproses = $this->calculatePercentageChange('Diproses');
        $persentaseSelesai = $this->calculatePercentageChange('Selesai');
        $persentaseUser = $this->calculateUserPercentageChange();

        return view('admin.dashboard', [
            'totalPengaduan' => $totalPengaduan,
            'pengaduanBaru' => $pengaduanBaru,
            'pengaduanDiproses' => $pengaduanDiproses,
            'pengaduanSelesai' => $pengaduanSelesai,
            'totalUserAktif' => $totalUserAktif,
            'chartData' => $chartData,
            'aktivitasTerbaru' => $aktivitasTerbaru,
            'persentaseBaru' => $persentaseBaru,
            'persentaseDiproses' => $persentaseDiproses,
            'persentaseSelesai' => $persentaseSelesai,
            'persentaseUser' => $persentaseUser,
        ]);
    }

    private function calculatePercentageChange($status)
    {
        // Hitung pengaduan minggu ini
        $mingguIni = Pengaduan::where('status', $status)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        // Hitung pengaduan minggu lalu
        $mingguLalu = Pengaduan::where('status', $status)
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();

        if ($mingguLalu == 0) {
            return $mingguIni > 0 ? ['value' => 100, 'isPositive' => true] : ['value' => 0, 'isPositive' => true];
        }

        $change = (($mingguIni - $mingguLalu) / $mingguLalu) * 100;
        return ['value' => round(abs($change), 1), 'isPositive' => $change >= 0];
    }

    private function calculateUserPercentageChange()
    {
        // Hitung user bulan ini
        $bulanIni = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Hitung user bulan lalu
        $bulanLalu = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($bulanLalu == 0) {
            return $bulanIni > 0 ? ['value' => 100, 'isPositive' => true] : ['value' => 0, 'isPositive' => true];
        }

        $change = (($bulanIni - $bulanLalu) / $bulanLalu) * 100;
        return ['value' => round(abs($change), 1), 'isPositive' => $change >= 0];
    }
}
