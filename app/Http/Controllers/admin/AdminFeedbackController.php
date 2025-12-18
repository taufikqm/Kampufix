<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar: pengaduan yang sudah ada rating/feedback
        $query = Pengaduan::with(['user', 'teknisi'])
            ->whereNotNull('rating')
            ->orderBy('updated_at', 'desc');

        // Filter by Teknisi
        if ($request->has('teknisi_id') && $request->teknisi_id) {
            $query->where('teknisi_id', $request->teknisi_id);
        }

        // Filter by Rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        $feedbacks = $query->paginate(10)->withQueryString();
        $teknisiList = User::where('role', 'teknisi')->get();

        // Statistik
        $totalFeedback = Pengaduan::whereNotNull('rating')->count();
        $avgRating = Pengaduan::whereNotNull('rating')->avg('rating') ?? 0;
        
        // Teknisi dengan rating tertinggi (min 1 feedback)
        $topTeknisi = User::where('role', 'teknisi')
            ->withAvg(['pengaduans as avg_rating' => function($q) {
                $q->whereNotNull('rating');
            }], 'rating')
            ->withCount(['pengaduans as total_feedback' => function($q) {
                $q->whereNotNull('rating');
            }])
            ->having('total_feedback', '>', 0)
            ->orderByDesc('avg_rating')
            ->first();

        return view('admin.feedback.index', compact('feedbacks', 'teknisiList', 'totalFeedback', 'avgRating', 'topTeknisi'));
    }
}
