@extends('layouts.admin')

@section('title', 'Dashboard Admin | ReadSpace')
@section('header_title', 'Dashboard Admin')

@section('content')

<div class="p-8 md:p-10">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <div class="h-1 w-20 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full mb-4"></div>
            <h1
                class="text-4xl md:text-5xl font-bold mb-2 bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Dashboard Admin
            </h1>
            <p class="text-gray-600">
                Kelola seluruh sistem perpustakaan digital dari satu tempat
            </p>
        </div>

        <div class="bg-white rounded-2xl px-6 py-4 shadow-lg border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Selamat datang,</p>
            <p
                class="text-lg font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                {{ Auth::user()->nama_lengkap }}
            </p>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <!-- Total Buku -->
        <div
            class="group relative bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl p-6 text-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div
                        class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold mb-2">{{ $totalBooks }}</div>
                <p class="text-sm text-purple-100 font-medium">Total Koleksi Buku</p>
            </div>
        </div>

        <!-- Total Pengguna -->
        <div
            class="group relative bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div
                        class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold mb-2">{{ $totalUsers }}</div>
                <p class="text-sm text-pink-100 font-medium">Pengguna Terdaftar</p>
            </div>
        </div>

        <!-- Peminjaman -->
        <div
            class="group relative bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div
                        class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold mb-2">{{ $borrowed }}</div>
                <p class="text-sm text-blue-100 font-medium">Sedang Dipinjam</p>
            </div>
        </div>

        <!-- Terlambat -->
        <div
            class="group relative bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div
                        class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-4xl font-bold mb-2">{{ $overdue }}</div>
                <p class="text-sm text-emerald-100 font-medium">Keterlambatan</p>
            </div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <!-- QUICK ACTIONS -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Aksi Cepat</h2>
        <p class="text-gray-600">Akses menu utama untuk manajemen perpustakaan</p>
    </div>

<!-- QUICK ACTIONS -->
        <div class="grid md:grid-cols-3 gap-6">
            
            <!-- Kelola Buku -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-purple-600 to-purple-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Kelola Buku</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Tambah, edit, dan hapus koleksi buku perpustakaan digital Anda.
                </p>
                <a href="{{ route('books') }}" class="inline-flex items-center gap-2 text-purple-600 font-semibold group-hover:gap-4 transition-all duration-300">
                    <span>Kelola Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <!-- Kelola Pengguna -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-pink-600 to-rose-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-pink-100 to-pink-200 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Kelola Pengguna</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Manajemen admin, petugas perpustakaan, dan pembaca terdaftar.
                </p>
                <a href="{{ route('account') }}" class="inline-flex items-center gap-2 text-pink-600 font-semibold group-hover:gap-4 transition-all duration-300">
                    <span>Kelola Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <!-- Kelola Peminjaman -->
            <div class="group bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-600 to-cyan-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Kelola Peminjaman</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Monitor dan kontrol seluruh aktivitas peminjaman buku secara real-time.
                </p>
                <a href="{{ route('peminjaman') }}" class="inline-flex items-center gap-2 text-blue-600 font-semibold group-hover:gap-4 transition-all duration-300">
                    <span>Kelola Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

        </div>

        <!-- RECENT ACTIVITY -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mt-16">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">Peminjaman Terbaru</h2>
                <a href="{{ route('peminjaman') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">Peminjam</th>
                            <th class="px-6 py-3">Buku</th>
                            <th class="px-6 py-3">Tanggal Pinjam</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentPeminjaman as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 font-medium text-gray-900">{{ $item->user->nama_lengkap ?? '-' }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $item->book->title ?? '-' }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-center">
                                @if($item->status == 'dipinjam')
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Dipinjam</span>
                                @elseif($item->status == 'dikembalikan')
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Dikembalikan</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Terlambat</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada aktivitas peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

</main>
@endsection
