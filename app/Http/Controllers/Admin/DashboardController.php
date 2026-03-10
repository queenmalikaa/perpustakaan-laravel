<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $borrowed = Peminjaman::where('status', 'dipinjam')->count();
        $overdue = Peminjaman::where('status', 'terlambat')->count();
        $recentPeminjaman = Peminjaman::with(['user', 'book'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalBooks', 'totalUsers', 'borrowed', 'overdue', 'recentPeminjaman'));
    }
}