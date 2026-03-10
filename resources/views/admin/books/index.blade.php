@extends('layouts.admin')

@section('title', 'Daftar Buku | Admin ReadSpace')
@section('header_title', 'Manajemen Buku')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        📚 Daftar Buku
                    </h1>
                    <p class="text-gray-600">
                        Kelola koleksi buku perpustakaan Anda
                    </p>
                </div>

                <a
                    href="{{ route('books.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:from-purple-700 hover:to-blue-700 transition-all duration-200 font-semibold"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Buku
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Buku</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalBooks }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tersedia</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $available }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-amber-100 rounded-lg">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Dipinjam</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $borrowed }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEARCH & FILTER -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form action="{{ route('books') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1 relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul buku, penulis, atau kategori..."
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                    >
                </div>

                <!-- Category Filter -->
                <select name="category_id" onchange="this.form.submit()" class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Status Filter -->
                <select name="status" onchange="this.form.submit()" class="px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia (Stok > 0)</option>
                    <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Habis (Stok 0)</option>
                </select>
            </form>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cover</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul Buku</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($books as $book)
                        <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <img
                                    src="{{ $book->cover ? asset('images/books/'.$book->cover) : 'https://via.placeholder.com/50x70' }}"
                                    class="w-12 h-16 rounded-lg shadow-md object-cover border border-gray-200"
                                    alt="Cover Buku"
                                >
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $book->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $book->author }} • {{ $book->tahun_terbit }}</p>
                                    <p class="text-xs text-gray-400">{{ $book->code }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                    {{ $book->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-700 font-semibold">
                                    {{ $book->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($book->stock > 0)
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('books.edit', $book->id) }}" class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-150" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-150" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data buku.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-100">
                
                <!-- Mobile Card 1 -->
                <div class="p-4 hover:bg-purple-50/50 transition-colors duration-150">
                    <div class="flex gap-4">
                        <img
                            src="https://via.placeholder.com/50x70"
                            class="w-16 h-20 rounded-lg shadow-md object-cover border border-gray-200 flex-shrink-0"
                            alt="Cover Buku"
                        >
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 mb-1">Laskar Pelangi</h3>
                            <p class="text-sm text-gray-500 mb-2">Andrea Hirata • 2005</p>
                            
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Novel</span>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Tersedia</span>
                                <span class="text-sm text-gray-600">Stok: <span class="font-semibold">12</span></span>
                            </div>

                            <div class="flex gap-2">
                                <button class="flex-1 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 text-sm font-medium">
                                    Edit
                                </button>
                                <button class="flex-1 px-3 py-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 text-sm font-medium">
                                    Detail
                                </button>
                                <button class="px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Card 2 -->
                <div class="p-4 hover:bg-purple-50/50 transition-colors duration-150">
                    <div class="flex gap-4">
                        <img
                            src="https://via.placeholder.com/50x70"
                            class="w-16 h-20 rounded-lg shadow-md object-cover border border-gray-200 flex-shrink-0"
                            alt="Cover Buku"
                        >
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 mb-1">Bumi Manusia</h3>
                            <p class="text-sm text-gray-500 mb-2">Pramoedya A. Toer • 1980</p>
                            
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Sejarah</span>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Dipinjam</span>
                                <span class="text-sm text-gray-600">Stok: <span class="font-semibold">5</span></span>
                            </div>

                            <div class="flex gap-2">
                                <button class="flex-1 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 text-sm font-medium">
                                    Edit
                                </button>
                                <button class="flex-1 px-3 py-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 text-sm font-medium">
                                    Detail
                                </button>
                                <button class="px-3 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pagination -->
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold">{{ $books->firstItem() ?? 0 }}</span> sampai <span class="font-semibold">{{ $books->lastItem() ?? 0 }}</span> dari <span class="font-semibold">{{ $books->total() }}</span> buku
                    </p>
                    
                    {{ $books->links() }}
                </div>
            </div>

        </div>

    </div>
</div>

@endsection