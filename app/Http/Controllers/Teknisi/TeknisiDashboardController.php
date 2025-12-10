<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class TeknisiDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        // Filter: hanya pengaduan yang ditugaskan ke teknisi yang login
        $query->where('teknisi_id', auth()->id());

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('subjek', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Order by tanggal terbaru
        $query->orderBy('created_at', 'desc');

        // Pagination
        $pengaduans = $query->paginate(10)->withQueryString();

        return view('teknisi.dashboard', compact('pengaduans'));
    }

    // Dashboard -> ringkasan saja
    public function detail($id) {
        $pengaduan = \App\Models\Pengaduan::where('teknisi_id', auth()->id())->findOrFail($id);
        return view('teknisi.summary', compact('pengaduan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai'
        ]);

        $pengaduan = Pengaduan::where('teknisi_id', auth()->id())
            ->findOrFail($id);

        $pengaduan->status = $request->status;
        $pengaduan->save();

        return back()->with('success', 'Status berhasil diperbarui');
    }

    public function dokumentasiForm($id)
    {
        $pengaduan = Pengaduan::where('teknisi_id', auth()->id())
            ->findOrFail($id);

        return view('teknisi.dokumentasi', compact('pengaduan'));
    }

    public function dokumentasiStore(Request $request, $id)
    {
        $request->validate([
            'catatan_perbaikan' => 'required|string|min:10',
            'foto_perbaikan' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240', // 10MB
        ]);

        $pengaduan = Pengaduan::where('teknisi_id', auth()->id())
            ->findOrFail($id);

        // Upload foto perbaikan
        $fotoPath = null;
        if ($request->hasFile('foto_perbaikan')) {
            $fotoPath = $request->file('foto_perbaikan')->store('perbaikan_foto', 'public');
        }

        $pengaduan->catatan_perbaikan = $request->catatan_perbaikan;
        $pengaduan->foto_perbaikan = $fotoPath;
        $pengaduan->status = 'Selesai'; // Otomatis ubah status jadi Selesai
        $pengaduan->save();

        return redirect()
            ->route('teknisi.pengaduan.detail', $pengaduan->id)
            ->with('success', 'Dokumentasi perbaikan berhasil dikirim!');
    }

    public function tasks(Request $request)
    {
        $query = \App\Models\Pengaduan::query();
        $query->where('teknisi_id', auth()->id());
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('subjek', 'like', "%{$search}%");
            });
        }
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        $query->orderBy('created_at', 'desc');
        $tasks = $query->paginate(10)->withQueryString();
        return view('teknisi.tasks', compact('tasks'));
    }

    // Tugas Saya -> detail interaktif (fitur aksi, dsb)
    public function taskDetail($id) {
        $pengaduan = \App\Models\Pengaduan::where('teknisi_id', auth()->id())->findOrFail($id);
        return view('teknisi.detail', compact('pengaduan'));
    }
}

