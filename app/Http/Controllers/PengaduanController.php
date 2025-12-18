<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function create()
    {
        $kategoris = \App\Models\Kategori::orderBy('nama')->get();
        return view('pengaduan.form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required|email',
            'lokasi' => 'nullable|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'subjek' => 'required',
            'deskripsi' => 'required',
            'foto' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pengaduan_foto', 'public');
        }

        // Simpan Pengaduan
        $maxKode = Pengaduan::whereYear('created_at', now()->year)->max('kode');
        $lastNumber = $maxKode ? (int) Str::afterLast($maxKode, '-') : 0;
        $kode = 'FAC-' . now()->year . '-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        Pengaduan::create([
            'user_id' => Auth::id(),
            'kode' => $kode,
            'kategori_id' => $request->kategori_id,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'lokasi' => $request->lokasi,
            'subjek' => $request->subjek,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
        ]);

        // 🔥 FIX UTAMA: redirect ke dashboard + tab riwayat
        return redirect()
            ->route('mahasiswa.dashboard', ['tab' => 'riwayat'])
            ->with('success', 'Pengaduan berhasil dikirim!');
    }

    public function riwayat()
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengaduan.riwayat', compact('pengaduan'));
    }

    public function detail($id)
    {
        $pengaduan = Pengaduan::with(['teknisi', 'kategori', 'progressPengerjaans'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pengaduan.detail', compact('pengaduan'));
    }

    public function showFeedbackForm($id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->where('status', 'Selesai')
            ->findOrFail($id);

        // Jika sudah memberikan feedback, redirect ke detail
        if ($pengaduan->rating || $pengaduan->feedback) {
            return redirect()->route('mahasiswa.pengaduan.detail', $pengaduan->id)
                ->with('info', 'Anda sudah memberikan feedback untuk pengaduan ini.');
        }

        return view('pengaduan.feedback', compact('pengaduan'));
    }

    public function edit($id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->where('status', 'Menunggu')
            ->findOrFail($id);

        return view('pengaduan.edit', compact('pengaduan'));
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->where('status', 'Menunggu')
            ->findOrFail($id);

        $validated = $request->validate([
            'subjek' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pengaduan_foto', 'public');
        }

        $pengaduan->update($validated);

        return redirect()->route('mahasiswa.pengaduan.detail', $pengaduan->id)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->where('status', 'Menunggu')
            ->findOrFail($id);

        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('mahasiswa.dashboard', ['tab' => 'riwayat'])
            ->with('success', 'Pengaduan berhasil dihapus.');
    }

    public function feedback(Request $request, $id)
    {
        $pengaduan = \App\Models\Pengaduan::where('user_id', Auth::id())
            ->where('status', 'Selesai')
            ->findOrFail($id);
        if ($pengaduan->rating || $pengaduan->feedback) {
            return back()->with('error', 'Feedback sudah diberikan sebelumnya.');
        }
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:500',
        ]);
        $pengaduan->rating = $validated['rating'];
        $pengaduan->feedback = $validated['feedback'] ?? null;
        $pengaduan->save();
        return redirect()->route('mahasiswa.pengaduan.detail', $pengaduan->id)
            ->with('success', 'Terima kasih, feedback Anda telah terkirim!');
    }
}
