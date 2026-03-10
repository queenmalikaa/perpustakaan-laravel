<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'book'])->latest();

        $statusFilter = $request->get('status');

        if ($statusFilter == 'history') {
            $query->whereIn('status', ['dikembalikan', 'ditolak']);
        }
        else {
            // Default / active: show ALL active records including pending
            $query->whereIn('status', ['pending', 'dipinjam', 'terlambat', 'pengajuan_kembali']);
        }

        $peminjaman = $query->paginate(10);

        // Auto-update terlambat
        foreach ($peminjaman as $item) {
            if ($item->status == 'dipinjam' && Carbon::parse($item->tanggal_kembali)->isPast()) {
                $item->update(['status' => 'terlambat']);
            }
        }

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'user')->get();
        $books = Book::where('stock', '>', 0)->get();
        return view('admin.peminjaman.create', compact('users', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Stok buku tidak tersedia.');
        }

        $activeLoansCount = Peminjaman::where('user_id', $request->user_id)
            ->whereIn('status', ['dipinjam', 'terlambat', 'pengajuan_kembali'])
            ->count();

        if ($activeLoansCount >= 3) {
            return redirect()->back()->with('error', 'Peminjaman gagal. User sudah meminjam 3 buku.');
        }

        Peminjaman::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        $book->decrement('stock');

        return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with(['user', 'book'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $users = User::where('role', 'user')->get();
        $books = Book::all();
        return view('admin.peminjaman.edit', compact('peminjaman', 'users', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat,pengajuan_kembali',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->only(['tanggal_kembali', 'status']));

        return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (in_array($peminjaman->status, ['dipinjam', 'terlambat', 'pengajuan_kembali'])) {
            $peminjaman->book->increment('stock');
        }

        $peminjaman->delete();
        return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil dihapus.');
    }

    /**
     * Confirm a pending loan request (pending → dipinjam).
     */
    public function confirm(string $id)
    {
        $peminjaman = Peminjaman::with('book')->findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Hanya permintaan pending yang bisa dikonfirmasi.');
        }

        if ($peminjaman->book->stock <= 0) {
            return back()->with('error', 'Stok buku habis, tidak dapat dikonfirmasi.');
        }

        $peminjaman->update(['status' => 'dipinjam']);
        $peminjaman->book->decrement('stock');

        return back()->with('success', 'Permintaan peminjaman berhasil dikonfirmasi.');
    }

    /**
     * Reject a pending loan request (pending → ditolak).
     * Record disimpan dengan status ditolak (tidak dihapus).
     */
    public function reject(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Hanya permintaan pending yang bisa ditolak.');
        }

        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('success', 'Permintaan peminjaman berhasil ditolak.');
    }

    /**
     * Confirm a return request (pengajuan_kembali → dikembalikan).
     */
    public function confirmReturn(string $id)
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

        return back()->with('success', 'Pengembalian buku berhasil dikonfirmasi.');
    }

    /**
     * Return a borrowed book directly (admin action — legacy support).
     */
    public function returnBook(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => Carbon::now(),
        ]);

        $peminjaman->book->increment('stock');

        return redirect()->route('peminjaman')->with('success', 'Buku berhasil dikembalikan.');
    }
}
