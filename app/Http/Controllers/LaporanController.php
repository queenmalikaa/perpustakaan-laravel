<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'peminjaman'); // Default to 'peminjaman'

        // Data for the view
        $data = [];
        $stats = [];

        if ($type === 'buku') {
            $query = \App\Models\Book::with('category');

            // Filter by Category if needed
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            $data['books'] = $query->latest()->get();

            // Stats for Buku
            $stats = [
                'total_buku' => $data['books']->count(),
                'total_stok' => $data['books']->sum('stock'),
            ];

        }
        elseif ($type === 'pengembalian') {
            $query = \App\Models\Peminjaman::with(['user', 'book'])
                ->where('status', 'dikembalikan');

            // Filter Date Range for Return Date
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('tanggal_dikembalikan', [$request->start_date, $request->end_date]);
            }

            $data['pengembalian'] = $query->latest('tanggal_dikembalikan')->get();

            // Stats for Pengembalian
            $stats = [
                'total_dikembalikan' => $data['pengembalian']->count(),
            ];

        }
        elseif ($type === 'anggota') {
            $query = \App\Models\User::where('role', 'user');

            // Filter Date Range for Join Date
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereDate('created_at', '>=', $request->start_date)
                    ->whereDate('created_at', '<=', $request->end_date);
            }

            $data['anggota'] = $query->latest()->get();

            // Stats for Anggota
            $stats = [
                'total_anggota' => $data['anggota']->count(),
            ];

        }
        else {
            // Default: Peminjaman
            $query = \App\Models\Peminjaman::with(['user', 'book']);

            // Filter Date Range for Borrow Date
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
            }

            // Filter Status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $data['peminjaman'] = $query->latest()->get();

            // Stats for Peminjaman
            $peminjamanAll = clone $query;
            $allPeminjaman = $peminjamanAll->get();
            $stats = [
                'total_peminjaman' => $allPeminjaman->count(),
                'total_dipinjam' => $allPeminjaman->where('status', 'dipinjam')->count(),
                'total_terlambat' => $allPeminjaman->where('status', 'terlambat')->count(),
            ];
        }

        return view('admin.laporan.index', compact('type', 'data', 'stats'));
    }
}
