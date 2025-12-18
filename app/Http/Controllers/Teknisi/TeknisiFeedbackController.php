<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;

class TeknisiFeedbackController extends Controller
{
    public function index(Request $request)
    {
        $feedbacks = Pengaduan::where('teknisi_id', auth()->id())
            ->where(function($q) {
                $q->whereNotNull('rating')
                  ->orWhereNotNull('feedback');
            })
            ->with('user') // Eager load user pelapor
            ->orderByDesc('updated_at')
            ->get();
        return view('teknisi.feedback', compact('feedbacks'));
    }
}
