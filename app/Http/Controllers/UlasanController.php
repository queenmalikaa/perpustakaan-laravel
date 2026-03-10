<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    // Tampilkan semua ulasan (admin view)
    public function index(Request $request)
    {
        $query = Ulasan::with(['user', 'book'])
            ->latest();

        // Filter by book
        if ($request->filled('book')) {
            $query->whereHas('book', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->book . '%');
            });
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $ulasan = $query->paginate(20);

        // Summary stats
        $totalUlasan = Ulasan::count();
        $avgRating = Ulasan::avg('rating');
        $bintang5 = Ulasan::where('rating', 5)->count();
        $bintang1 = Ulasan::where('rating', 1)->count();

        return view('admin.ulasan.index', compact(
            'ulasan', 'totalUlasan', 'avgRating', 'bintang5', 'bintang1'
        ));
    }

    // Hapus ulasan
    public function destroy($id)
    {
        Ulasan::findOrFail($id)->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
