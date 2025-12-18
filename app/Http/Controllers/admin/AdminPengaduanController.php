<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPengaduanController extends Controller
{
    public function index()
    {
        return view('admin.pengaduan.index', [
            'pengaduan' => Pengaduan::latest()->get()
        ]);
    }

    public function detail($id)
    {
        $teknisiList = User::where('role', 'teknisi')->get();
        
        return view('admin.pengaduan.detail', [
            'p' => Pengaduan::with(['teknisi', 'progressPengerjaans'])->findOrFail($id),
            'teknisiList' => $teknisiList
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'teknisi_id' => 'nullable|exists:users,id'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->status = $request->status;
        
        // Jika status bukan "Baru" dan ada teknisi_id, assign ke teknisi
        if ($request->status !== 'Baru' && $request->teknisi_id) {
            $pengaduan->teknisi_id = $request->teknisi_id;
        }
        
        // Jika status "Baru", reset teknisi_id
        if ($request->status === 'Baru') {
            $pengaduan->teknisi_id = null;
        }

        $pengaduan->save();

        return back()->with('success', 'Pengaduan berhasil diperbarui');
    }
}
