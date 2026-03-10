<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Stats
        $booksBorrowed = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();

        $totalHistory = Peminjaman::where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->count();

        // Recent Activity
        $recentActivity = Peminjaman::with('book')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('booksBorrowed', 'totalHistory', 'recentActivity'));
    }
}
