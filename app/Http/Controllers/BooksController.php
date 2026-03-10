<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Book;
use App\Models\Peminjaman;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = Book::with('category');

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $books->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%');
            });
        }

        // Filter Category
        if ($request->has('category_id') && $request->category_id != '') {
            $books->where('category_id', $request->category_id);
        }

        // Filter Status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'available') {
                $books->where('stock', '>', 0);
            }
            elseif ($request->status == 'unavailable') {
                $books->where('stock', '<=', 0);
            }
        }

        $books = $books->latest()->paginate(10);
        $categories = Category::all();

        // Stats
        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $borrowed = Peminjaman::where('status', 'dipinjam')->count();
        $available = $totalStock - $borrowed;

        return view('admin.books.index', compact('books', 'categories', 'totalBooks', 'available', 'borrowed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $code = 'BK-' . rand(1000, 9999);
        return view('admin.books.create', compact('categories', 'code'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:books',
            'author' => 'required',
            'publisher' => 'required',
            'category_id' => 'required',
            'year' => 'required|numeric',
            'stock' => 'required|numeric',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $input = $request->all();

        // Map year to tahun_terbit
        $input['tahun_terbit'] = $request->year;

        if ($image = $request->file('cover')) {
            $destinationPath = 'images/books/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['cover'] = "$profileImage";
        }

        Book::create($input);

        return redirect()->route('books')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'code' => 'required|unique:books,code,' . $id,
            'author' => 'required',
            'publisher' => 'required',
            'category_id' => 'required',
            'year' => 'required|numeric',
            'stock' => 'required|numeric',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $book = Book::findOrFail($id);
        $input = $request->all();
        $input['tahun_terbit'] = $request->year;

        if ($image = $request->file('cover')) {
            $destinationPath = 'images/books/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['cover'] = "$profileImage";

        // Should verify if old cover exists and delete it, but optional for now
        }
        else {
            unset($input['cover']);
        }

        $book->update($input);

        return redirect()->route('books')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books')->with('success', 'Buku berhasil dihapus.');
    }
}
