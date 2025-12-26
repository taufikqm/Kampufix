<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminTeknisiController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'teknisi');

        // Filter by on_duty status
        if ($request->has('status') && $request->status !== '') {
            $query->where('on_duty', $request->status === 'on_duty');
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $teknisis = $query->orderBy('on_duty', 'desc')
                          ->orderBy('name', 'asc')
                          ->paginate(10)
                          ->withQueryString();

        return view('admin.teknisi.index', compact('teknisis'));
    }

    public function create()
    {
        return view('admin.teknisi.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'on_duty' => 'boolean',
        ]);

        $validated['role'] = 'teknisi';
        $validated['password'] = Hash::make($validated['password']);
        $validated['on_duty'] = $request->has('on_duty') ? true : false;

        User::create($validated);

        return redirect()->route('admin.teknisi.index')
            ->with('success', 'Teknisi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $teknisi = User::where('role', 'teknisi')->findOrFail($id);
        return view('admin.teknisi.form', compact('teknisi'));
    }

    public function update(Request $request, $id)
    {
        $teknisi = User::where('role', 'teknisi')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'on_duty' => 'boolean',
        ]);

        // Hanya update password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['on_duty'] = $request->has('on_duty') ? true : false;

        $teknisi->update($validated);

        return redirect()->route('admin.teknisi.index')
            ->with('success', 'Profil teknisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $teknisi = User::where('role', 'teknisi')->findOrFail($id);

        // Cek apakah teknisi masih memiliki pengaduan
        if ($teknisi->pengaduans()->count() > 0) {
            return back()->with('error', 'Teknisi tidak bisa dihapus karena masih memiliki ' . $teknisi->pengaduans()->count() . ' pengaduan.');
        }

        $teknisi->delete();

        return redirect()->route('admin.teknisi.index')
            ->with('success', 'Teknisi berhasil dihapus.');
    }

    public function toggleDuty($id)
    {
        $teknisi = User::where('role', 'teknisi')->findOrFail($id);
        $teknisi->on_duty = !$teknisi->on_duty;
        $teknisi->save();

        $status = $teknisi->on_duty ? 'on duty' : 'off duty';
        return back()->with('success', "Status teknisi berhasil diubah menjadi {$status}.");
    }
}
