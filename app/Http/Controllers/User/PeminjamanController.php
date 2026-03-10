<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $userId = Auth::id();

        $query = Peminjaman::with('book')->where('user_id', $userId);

        if ($status == 'history') {
            $query->whereIn('status', ['dikembalikan', 'ditolak']);
            $title = 'Riwayat Peminjaman';
        }
        elseif ($status == 'active') {
            $query->whereIn('status', ['dipinjam', 'terlambat', 'pengajuan_kembali']);
            $title = 'Buku Sedang Dipinjam';
        }
        else {
            // pending tab
            $query->where('status', 'pending');
            $title = 'Menunggu Konfirmasi';
        }

        $peminjaman = $query->latest()->paginate(10);

        // Untuk tab Riwayat: ambil IDs buku yang sudah dikembalikan (untuk gating ulasan)
        $returnedBookIds = [];
        if ($status == 'history') {
            $returnedBookIds = Peminjaman::where('user_id', $userId)
                ->where('status', 'dikembalikan')
                ->pluck('book_id')
                ->toArray();
        }

        return view('user.peminjaman.index', compact('peminjaman', 'status', 'title', 'returnedBookIds'));
    }

    /**
     * User mengajukan pengembalian buku (dipinjam/terlambat → pengajuan_kembali)
     */
    public function requestReturn($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->firstOrFail();

        $peminjaman->update(['status' => 'pengajuan_kembali']);

        return back()->with('success', 'Pengajuan pengembalian berhasil dikirim. Tunggu konfirmasi admin.');
    }

    /**
     * User cancels their own pending request
     */
    public function cancel($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $peminjaman->delete();

        return back()->with('success', 'Permintaan peminjaman berhasil dibatalkan.');
    }
}
