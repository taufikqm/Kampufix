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
            ->whereNotNull('rating')
            ->orWhere(function($q) {
                $q->whereNotNull('feedback')->where('teknisi_id', auth()->id());
            })
            ->orderByDesc('created_at')
            ->get();
        return view('teknisi.feedback', compact('feedbacks'));
    }
}
