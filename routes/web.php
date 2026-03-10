<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UlasanController;

// Landing page
Route::get('/', function () {
    $featuredBooks = \App\Models\Book::with('category')
        ->where('stock', '>', 0)
        ->inRandomOrder()
        ->take(8)
        ->get();
    return view('landingpage', compact('featuredBooks'));
})->name('landingpage');

// Route untuk Register & Login
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class , 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class , 'store']);

    Route::get('/login', [AuthenticatedSessionController::class , 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class , 'store']);
});

// Route yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
});

// Route untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class , 'index'])
        ->name('admin.dashboard');

    // Staff / Petugas (Admin Only)
    Route::get('/account', [AccountController::class , 'index'])->name('account');
    Route::get('/account/pembaca', [AccountController::class , 'pembaca'])->name('account.pembaca');
    Route::get('/account/create', [AccountController::class , 'create'])->name('account.create');
    Route::post('/account/store', [AccountController::class , 'store'])->name('account.store');
    Route::get('/account/edit/{id}', [AccountController::class , 'edit'])->name('account.edit');
    Route::put('/account/update/{id}', [AccountController::class , 'update'])->name('account.update');
    Route::delete('/account/destroy/{id}', [AccountController::class , 'destroy'])->name('account.destroy');
});

// Route untuk Admin & Petugas (Shared)
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {

    Route::get('/search-books', [BooksController::class , 'search'])->name('books.search');

    // ULASAN
    Route::get('/admin/ulasan', [UlasanController::class , 'index'])->name('admin.ulasan');
    Route::delete('/admin/ulasan/{id}', [UlasanController::class , 'destroy'])->name('admin.ulasan.destroy');

    // BOOK
    Route::get('/books', [BooksController::class , 'index'])->name('books');
    Route::get('/books/create', [BooksController::class , 'create'])->name('books.create');
    Route::post('/books/store', [BooksController::class , 'store'])->name('books.store');
    Route::get('/books/edit/{id}', [BooksController::class , 'edit'])->name('books.edit');
    Route::put('/books/update/{id}', [BooksController::class , 'update'])->name('books.update');
    Route::delete('/books/destroy/{id}', [BooksController::class , 'destroy'])->name('books.destroy');

    // Kategori Buku
    Route::get('/categories', [CategoryController::class , 'index'])->name('category');
    Route::get('/categories/create', [CategoryController::class , 'create'])->name('category.create');
    Route::get('/categories/edit/{id}', [CategoryController::class , 'edit'])->name('category.edit');
    Route::post('/categories/store', [CategoryController::class , 'store'])->name('category.store');
    Route::delete('/categories/destroy/{id}', [CategoryController::class , 'destroy'])->name('category.destroy');
    Route::put('/categories/update/{id}', [CategoryController::class , 'update'])->name('category.update');

    // Peminjam
    Route::get('/peminjaman', [PeminjamanController::class , 'index'])->name('peminjaman');
    Route::get('/peminjaman/create', [PeminjamanController::class , 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/store', [PeminjamanController::class , 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/edit/{id}', [PeminjamanController::class , 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/update/{id}', [PeminjamanController::class , 'update'])->name('peminjaman.update');
    Route::put('/peminjaman/return/{id}', [PeminjamanController::class , 'returnBook'])->name('peminjaman.return');
    Route::put('/peminjaman/confirm/{id}', [PeminjamanController::class , 'confirm'])->name('peminjaman.confirm');
    Route::put('/peminjaman/confirm-return/{id}', [PeminjamanController::class , 'confirmReturn'])->name('peminjaman.confirmReturn');
    Route::put('/peminjaman/reject/{id}', [PeminjamanController::class , 'reject'])->name('peminjaman.reject');
    Route::delete('/peminjaman/destroy/{id}', [PeminjamanController::class , 'destroy'])->name('peminjaman.destroy');

    // Pengembalian
    Route::get('/pengembalian', [PengembalianController::class , 'index'])->name('pengembalian');
    Route::put('/pengembalian/confirm/{id}', [PengembalianController::class , 'confirm'])->name('pengembalian.confirm');
    Route::put('/pengembalian/reject/{id}', [PengembalianController::class , 'reject'])->name('pengembalian.reject');

    // Laporan
    Route::get('/laporan', [LaporanController::class , 'index'])->name('laporan');
});

// Route untuk Petugas
Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', [App\Http\Controllers\Petugas\DashboardController::class , 'index'])
        ->name('petugas.dashboard');
});

// Route untuk User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [App\Http\Controllers\User\DashboardController::class , 'index'])
        ->name('user.dashboard');

    // User Peminjaman (My Loans)
    Route::get('/user/peminjaman', [App\Http\Controllers\User\PeminjamanController::class , 'index'])
        ->name('user.peminjaman');
    Route::delete('/user/peminjaman/cancel/{id}', [App\Http\Controllers\User\PeminjamanController::class , 'cancel'])
        ->name('user.peminjaman.cancel');
    Route::post('/user/peminjaman/return/{id}', [App\Http\Controllers\User\PeminjamanController::class , 'requestReturn'])
        ->name('user.peminjaman.requestReturn');

    // User Catalog & Collection
    Route::get('/user/catalog', [App\Http\Controllers\User\BookController::class , 'index'])
        ->name('user.catalog');

    Route::get('/user/catalog/{id}', [App\Http\Controllers\User\BookController::class , 'show'])
        ->name('user.catalog.show');

    Route::get('/user/collection', [App\Http\Controllers\User\BookController::class , 'collection'])
        ->name('user.collection');

    // Pinjam buku
    Route::post('/user/pinjam/{bookId}', [App\Http\Controllers\User\BookController::class , 'pinjam'])
        ->name('user.pinjam');

    // Toggle koleksi pribadi
    Route::post('/user/koleksi/{bookId}', [App\Http\Controllers\User\BookController::class , 'toggleKoleksi'])
        ->name('user.koleksi.toggle');

    // Ulasan buku
    Route::post('/user/catalog/{bookId}/ulasan', [App\Http\Controllers\User\BookController::class , 'submitUlasan'])
        ->name('user.ulasan.submit');
    Route::delete('/user/catalog/{bookId}/ulasan', [App\Http\Controllers\User\BookController::class , 'deleteUlasan'])
        ->name('user.ulasan.delete');
});

require __DIR__ . '/auth.php';