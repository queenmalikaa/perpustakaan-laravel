@extends('layouts.user')

@section('title', 'Koleksi Pribadi | ReadSpace')
@section('header_title', 'Koleksi Pribadi')

@section('content')
<div class="p-8 md:p-10">

    @if(session('success'))
    <div id="fl" class="mb-6 flex items-center gap-3 bg-purple-50 border border-purple-200 text-purple-700 px-5 py-4 rounded-xl">
        ✅ <span class="font-medium">{{ session('success') }}</span>
        <button onclick="document.getElementById('fl').remove()" class="ml-auto">✕</button>
    </div>
    @endif

    <!-- HEADER -->
    <div class="mb-8">
        <div class="h-1 w-20 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full mb-4"></div>
        <h1 class="text-4xl font-bold text-gray-800 mb-2 flex items-center gap-3">
            <svg class="w-9 h-9 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
            Koleksi Pribadi
        </h1>
        <p class="text-gray-500">Daftar buku yang kamu simpan sebagai koleksi.</p>
    </div>

    @if($koleksi->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-20 text-center">
            <svg class="w-20 h-20 text-gray-200 mx-auto mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-600 mb-2">Koleksi Masih Kosong</h3>
            <p class="text-gray-400 mb-6">Tambahkan buku favoritmu dari katalog.</p>
            <a href="{{ route('user.catalog') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700
                      text-white font-semibold rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Lihat Katalog
            </a>
        </div>
    @else
        <!-- GRID: wider cards 2 → 3 → 4 cols -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($koleksi as $item)
            @php $book = $item->book; @endphp
            @if($book)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl
                        hover:-translate-y-1 transition-all duration-300 overflow-hidden group">

                <!-- COVER -->
                <a href="{{ route('user.catalog.show', $book->id) }}" class="block relative overflow-hidden bg-white" style="aspect-ratio:3/4;max-height:280px;">
                    @if($book->cover)
                        <img src="{{ asset('images/books/' . $book->cover) }}"
                             alt="{{ $book->title }}"
                             class="w-full h-full object-contain p-1 group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-50 via-indigo-50 to-purple-50">
                            <svg class="w-20 h-20 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Bookmark badge -->
                    <div class="absolute top-2 left-2">
                        <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Stock badge -->
                    @if($book->stock <= 0)
                        <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-xs font-bold bg-red-500 text-white">Habis</span>
                    @else
                        <span class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-xs font-bold bg-purple-500 text-white">{{ $book->stock }} stok</span>
                    @endif
                </a>

                <!-- INFO -->
                <div class="p-5">
                    <a href="{{ route('user.catalog.show', $book->id) }}" class="block">
                        <h3 class="font-bold text-gray-800 text-base leading-snug mb-1 line-clamp-2 group-hover:text-purple-600 transition-colors">
                            {{ $book->title }}
                        </h3>
                        <p class="text-sm text-gray-500 mb-3 truncate">{{ $book->author }}</p>
                    </a>
                    @if($book->category)
                        <span class="inline-block px-3 py-1 rounded-full text-xs bg-blue-50 text-blue-700 font-semibold border border-blue-100 mb-4">
                            {{ $book->category->name }}
                        </span>
                    @endif

                    <!-- Actions -->
                    <div class="flex gap-2 pt-3 border-t border-gray-50">
                        @if($book->stock > 0)
                        <form method="POST" action="{{ route('user.pinjam', $book->id) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold
                                           rounded-xl text-sm transition-all flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Pinjam
                            </button>
                        </form>
                        @else
                        <div class="flex-1 py-2.5 bg-gray-100 text-gray-400 font-semibold rounded-xl text-sm text-center cursor-not-allowed">
                            Habis
                        </div>
                        @endif
                        <form method="POST" action="{{ route('user.koleksi.toggle', $book->id) }}">
                            @csrf
                            <button type="submit"
                                    class="py-2.5 px-3.5 bg-gray-100 border border-gray-200 text-gray-400
                                           hover:bg-red-50 hover:text-red-500 hover:border-red-200 rounded-xl text-sm transition-all"
                                    title="Hapus dari Koleksi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="mt-10">
            {{ $koleksi->links() }}
        </div>
    @endif

</div>
@endsection
