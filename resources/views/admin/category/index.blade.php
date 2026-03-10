@extends('layouts.admin')

@section('title', 'Kategori Buku | Admin ReadSpace')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        🏷️ Kategori Buku
                    </h1>
                    <p class="text-gray-600">
                        Kelola kategori untuk mengelompokkan koleksi buku perpustakaan
                    </p>
                </div>

                <a 
                    href="{{ route('category.create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:from-purple-700 hover:to-blue-700 transition-all duration-200 font-semibold"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kategori
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Kategori</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kategori Populer</p>
                            <p class="text-2xl font-bold text-gray-900">
                                {{ $popularCategory ? $popularCategory->name : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEARCH BAR -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form action="{{ route('category') }}" method="GET">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari kategori..."
                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                    >
                </div>
            </form>
        </div>

        @if($categories->isEmpty())
            <!-- EMPTY STATE -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-12">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Kategori</h3>
                    <p class="text-gray-600 mb-6">Mulai tambahkan kategori untuk mengelompokkan koleksi buku Anda</p>
                    <a
                        href="{{ route('category.create') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kategori Pertama
                    </a>
                </div>
            </div>
        @else
            <!-- CATEGORY CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                
                @php
                    $gradients = [
                        ['from-purple-500', 'to-pink-500', 'bg-purple-100', 'text-purple-600', 'text-purple-700'],
                        ['from-blue-500', 'to-cyan-500', 'bg-blue-100', 'text-blue-600', 'text-blue-700'],
                        ['from-emerald-500', 'to-teal-500', 'bg-emerald-100', 'text-emerald-600', 'text-emerald-700'],
                        ['from-red-500', 'to-rose-500', 'bg-red-100', 'text-red-600', 'text-red-700'],
                        ['from-amber-500', 'to-orange-500', 'bg-amber-100', 'text-amber-600', 'text-amber-700'],
                        ['from-indigo-500', 'to-purple-500', 'bg-indigo-100', 'text-indigo-600', 'text-indigo-700'],
                    ];
                @endphp

                @foreach($categories as $index => $category)
                    @php
                        $colorIndex = $index % count($gradients);
                        $colors = $gradients[$colorIndex];
                    @endphp

                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        <div class="h-3 bg-gradient-to-r {{ $colors[0] }} {{ $colors[1] }}"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="p-3 {{ $colors[2] }} rounded-xl group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6 {{ $colors[3] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $category->name }}</h3>
                                        <span class="inline-flex items-center gap-1 mt-1 px-2 py-1 rounded-full text-xs font-semibold {{ $colors[2] }} {{ $colors[4] }}">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                            </svg>
                                        
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $category->books_count }} Buku
                            </p>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex gap-2">
                                    <a
                                        href="{{ route('category.edit', $category->id) }}"
                                        class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-150" 
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form 
                                        action="{{ route('category.destroy', $category->id) }}"
                                        method="POST" 
                                        class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name }}? Semua buku dalam kategori ini akan terhapus juga.');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-150" 
                                            title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <a 
                                    href="{{ route('books') }}?category={{ $category->id }}" 
                                    class="text-sm font-medium {{ $colors[3] }} hover:opacity-80 flex items-center gap-1"
                                >
                                    Lihat Buku
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif

    </div>
</div>

@endsection