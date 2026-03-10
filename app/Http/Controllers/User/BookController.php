<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\KoleksiPribadi;
use App\Models\Peminjaman;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookController extends Controller
{
    // Katalog Buku
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->latest()->paginate(12);
        $categories = Category::all();

        $koleksiIds = [];
        if (Auth::check()) {
            $koleksiIds = KoleksiPribadi::where('user_id', Auth::id())
                ->pluck('book_id')->toArray();
        }

        return view('user.books.index', compact('books', 'categories', 'koleksiIds'));
    }

    // Detail Buku (Full Page)
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);

        $inKoleksi = false;
        if (Auth::check()) {
            $inKoleksi = KoleksiPribadi::where('user_id', Auth::id())
                ->where('book_id', $id)->exists();
        }

        // Buku yang sedang dipinjam/pending user ini
        $activeLoan = Peminjaman::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->whereIn('status', ['pending', 'dipinjam', 'terlambat', 'pengajuan_kembali'])
            ->first();

        // Apakah user sudah pernah mengembalikan buku ini (untuk gating ulasan)
        $sudahDikembalikan = Peminjaman::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->where('status', 'dikembalikan')
            ->exists();

        // Buku serupa (kategori sama)
        $related = Book::with('category')
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        // Ulasan buku ini
        $ulasanList = Ulasan::with('user')
            ->where('book_id', $id)
            ->latest()
            ->get();

        // Ulasan user sendiri (kalau sudah)
        $myUlasan = Ulasan::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->first();

        // Rata-rata rating
        $avgRating = $ulasanList->avg('rating');

        return view('user.books.show', compact(
            'book', 'inKoleksi', 'activeLoan', 'related',
            'ulasanList', 'myUlasan', 'avgRating', 'sudahDikembalikan'
        ));
    }

    // Submit / Update Ulasan
    public function submitUlasan(Request $request, $bookId)
    {
        // Gate: hanya boleh ulasan jika sudah pernah mengembalikan buku ini
        $sudahDikembalikan = Peminjaman::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->where('status', 'dikembalikan')
            ->exists();

        if (!$sudahDikembalikan) {
            return back()->with('error', 'Kamu hanya bisa memberikan ulasan setelah meminjam dan mengembalikan buku ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        Ulasan::updateOrCreate(
        ['user_id' => Auth::id(), 'book_id' => $bookId],
        ['rating' => $request->rating, 'komentar' => $request->komentar]
        );

        return back()->with('success', 'Ulasan berhasil disimpan!');
    }

    // Hapus Ulasan
    public function deleteUlasan($bookId)
    {
        Ulasan::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }


    // Koleksi Pribadi
    public function collection()
    {
        $koleksi = KoleksiPribadi::with('book.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('user.books.collection', compact('koleksi'));
    }

    // Pinjam Buku
    public function pinjam(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis, tidak dapat dipinjam.');
        }

        // Cek apakah user sudah meminjam/request buku ini (termasuk pengajuan_kembali)
        $existing = Peminjaman::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->whereIn('status', ['pending', 'dipinjam', 'terlambat', 'pengajuan_kembali'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah mengajukan atau meminjam buku ini.');
        }

        // Buat permintaan peminjaman dengan status pending
        Peminjaman::create([
            'user_id' => Auth::id(),
            'book_id' => $bookId,
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_kembali' => Carbon::today()->addDays(7),
            'status' => 'pending',
        ]);

        // Stok belum dikurangi — akan dikurangi saat admin konfirmasi

        return back()->with('success', 'Permintaan peminjaman "' . $book->title . '" telah dikirim. Tunggu konfirmasi admin.');
    }

    // Toggle Koleksi Pribadi
    public function toggleKoleksi(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);
        $userId = Auth::id();

        $existing = KoleksiPribadi::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if ($existing) {
            $existing->delete();
            $message = 'Buku dihapus dari koleksi pribadi.';
        }
        else {
            KoleksiPribadi::create([
                'user_id' => $userId,
                'book_id' => $bookId,
            ]);
            $message = 'Buku "' . $book->title . '" ditambahkan ke koleksi pribadi!';
        }

        return back()->with('success', $message);
    }
}
