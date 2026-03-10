@extends('layouts.user')

@section('title', 'Katalog Buku | ReadSpace')
@section('header_title', 'Katalog Buku')

@section('content')
<div class="p-8 md:p-10">

    <!-- FLASH MESSAGES -->
    @if(session('success'))
    <div id="fl" class="mb-6 flex items-center gap-3 bg-purple-50 border border-purple-200 text-purple-700 px-5 py-4 rounded-xl shadow-sm">
        <span>✅</span><span class="font-medium">{{ session('success') }}</span>
        <button onclick="document.getElementById('fl').remove()" class="ml-auto text-purple-400">✕</button>
    </div>
    @endif
    @if(session('error'))
    <div id="fle" class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl shadow-sm">
        <span>❌</span><span class="font-medium">{{ session('error') }}</span>
        <button onclick="document.getElementById('fle').remove()" class="ml-auto text-red-400">✕</button>
    </div>
    @endif

    <!-- HEADER -->
    <div class="mb-8">
        <div class="h-1 w-20 bg-gradient-to-r from-purple-500 to-purple-700 rounded-full mb-4"></div>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Katalog Buku</h1>
        <p class="text-gray-500">Temukan dan pinjam buku favoritmu.</p>
    </div>

    <!-- SEARCH & FILTER -->
    <form method="GET" action="{{ route('user.catalog') }}"
          class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-8 flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari judul atau pengarang..."
                   class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
        </div>
        <select name="category_id"
                class="px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-400">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <button type="submit"
                class="px-7 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            Cari
        </button>
        @if(request('search') || request('category_id'))
            <a href="{{ route('user.catalog') }}"
               class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium rounded-xl transition-all text-sm flex items-center gap-1">
                ✕ Reset
            </a>
        @endif
    </form>

    @if($books->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Buku tidak ditemukan</h3>
            <p class="text-gray-400">Coba kata kunci lain atau reset filter.</p>
        </div>
    @else
        <p class="text-sm text-gray-400 mb-5">
            Menampilkan {{ $books->firstItem() }}–{{ $books->lastItem() }} dari {{ $books->total() }} buku
        </p>

        <!-- GRID — 2 kolom di mobile, 3 di tablet, 4 di desktop -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($books as $book)
            <a href="{{ route('user.catalog.show', $book->id) }}"
               class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1
                       transition-all duration-300 overflow-hidden group block">

                <!-- COVER -->
                <div class="relative w-full overflow-hidden bg-white" style="aspect-ratio:3/4;max-height:280px;">
                    @if($book->cover)
                        <img src="{{ asset('images/books/' . $book->cover) }}"
                             alt="{{ $book->title }}"
                             class="w-full h-full object-contain p-1 group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-purple-50 via-purple-50 to-slate-50">
                            <svg class="w-20 h-20 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Stock badge -->
                    <div class="absolute top-2 right-2">
                        @if($book->stock <= 0)
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-500 text-white shadow">Habis</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-purple-500 text-white shadow">{{ $book->stock }} stok</span>
                        @endif
                    </div>

                    <!-- Koleksi badge (bookmark) -->
                    @if(in_array($book->id, $koleksiIds))
                        <div class="absolute top-2 left-2">
                            <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center shadow-md">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </div>
                        </div>
                    @endif

                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-all duration-300 flex items-center justify-center">
                        <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-white text-purple-600 font-bold text-sm px-4 py-2 rounded-full shadow-lg">
                            Lihat Detail →
                        </span>
                    </div>
                </div>

                <!-- INFO -->
                <div class="p-5">
                    <h3 class="font-bold text-gray-800 text-base leading-snug mb-1 line-clamp-2 group-hover:text-purple-600 transition-colors">
                        {{ $book->title }}
                    </h3>
                    <p class="text-sm text-gray-500 mb-3 truncate">{{ $book->author }}</p>
                    @if($book->category)
                        <span class="inline-block px-3 py-1 rounded-full text-xs bg-purple-50 text-purple-700 font-semibold border border-purple-100">
                            {{ $book->category->name }}
                        </span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <!-- PAGINATION -->
        <div class="mt-10">
            {{ $books->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection
