<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Halaman pengembalian:
     * - Tab default: pengajuan_kembali (menunggu konfirmasi admin)
     * - Tab history: dikembalikan
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'pengajuan');

        if ($tab == 'history') {
            $peminjaman = Peminjaman::with(['user', 'book'])
                ->where('status', 'dikembalikan')
                ->latest()
                ->paginate(10);
            $title = 'Riwayat Pengembalian';
        }
        else {
            $peminjaman = Peminjaman::with(['user', 'book'])
                ->where('status', 'pengajuan_kembali')
                ->latest()
                ->paginate(10);
            $title = 'Pengajuan Pengembalian';
        }

        return view('admin.pengembalian.index', compact('peminjaman', 'tab', 'title'));
    }

    /**
     * Konfirmasi pengembalian: pengajuan_kembali → dikembalikan
     */
    public function confirm(string $id)
    {
        $peminjaman = Peminjaman::with('book')->findOrFail($id);

        if ($peminjaman->status !== 'pengajuan_kembali') {
            return back()->with('error', 'Hanya pengajuan pengembalian yang bisa dikonfirmasi.');
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => Carbon::now(),
        ]);

        $peminjaman->book->increment('stock');

        return back()->with('success', 'Pengembalian buku "' . $peminjaman->book->title . '" berhasil dikonfirmasi.');
    }

    /**
     * Tolak pengembalian: pengajuan_kembali → dikembalikan ke sedang dipinjam
     */
    public function reject(string $id)
    {
        $peminjaman = Peminjaman::with('book')->findOrFail($id);

        if ($peminjaman->status !== 'pengajuan_kembali') {
            return back()->with('error', 'Hanya pengajuan pengembalian yang bisa ditolak.');
        }

        // Jika sudah melewati batas tanggal kembali, status menjadi terlambat, jika belum maka dipinjam
        $status = Carbon::now()->isAfter($peminjaman->tanggal_kembali) ? 'terlambat' : 'dipinjam';

        $peminjaman->update([
            'status' => $status,
        ]);

        return back()->with('success', 'Pengembalian buku "' . $peminjaman->book->title . '" berhasil ditolak dan status dikembalikan menjadi sedang dipinjam.');
    }
}
