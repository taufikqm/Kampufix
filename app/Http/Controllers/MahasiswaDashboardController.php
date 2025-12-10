<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class MahasiswaDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Hitung statistik
        $countPending = Pengaduan::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $countProcess = Pengaduan::where('user_id', $user->id)
            ->where('status', 'process')
            ->count();

        $countDone = Pengaduan::where('user_id', $user->id)
            ->where('status', 'done')
            ->count();

        // Semua riwayat (untuk halaman riwayat lengkap)
        $riwayat = Pengaduan::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil 2 riwayat terbaru untuk dashboard
        $latestRiwayat = Pengaduan::where('user_id', $user->id)
            ->latest()
            ->take(2)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'countPending',
            'countProcess',
            'countDone',
            'riwayat',
            'latestRiwayat'
        ));
    }

    public function riwayatFeedback()
    {
        $feedback = \App\Models\Pengaduan::where('user_id', Auth::id())
            ->where('status', 'Selesai')
            ->where(function($q){
                $q->whereNotNull('rating')->orWhereNotNull('feedback');
            })
            ->orderByDesc('updated_at')
            ->get();
        return view('mahasiswa.riwayat-feedback', compact('feedback'));
    }
}
