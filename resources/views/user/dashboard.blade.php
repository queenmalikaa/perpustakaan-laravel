@extends('layouts.user')

@section('title', 'Dashboard User | ReadSpace')
@section('header_title', 'Dashboard Pembaca')

@section('content')

<div class="p-8 md:p-10">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div>
            <div class="h-1 w-20 bg-gradient-to-r from-purple-500 to-purple-700 rounded-full mb-4"></div>
            <h1
                class="text-4xl md:text-5xl font-bold mb-2 bg-gradient-to-r from-purple-600 to-purple-700 bg-clip-text text-transparent pb-4">
                Dashboard Pembaca
            </h1>
            <p class="text-gray-600">
                Selamat datang kembali, temukan buku favoritmu hari ini!
            </p>
        </div>

        <div class="bg-white rounded-2xl px-6 py-4 shadow-lg border border-gray-100">
            <p class="text-sm text-gray-500 mb-1">Halo Pembaca,</p>
            <p
                class="text-lg font-bold bg-gradient-to-r from-purple-600 to-purple-700 bg-clip-text text-transparent">
                {{ Auth::user()->nama_lengkap }}
            </p>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid md:grid-cols-2 gap-6 mb-10">

        <!-- Sedang Dipinjam -->
        <div
            class="group relative bg-gradient-to-br from-purple-500 to-purple-800 rounded-2xl p-8 text-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
            <div class="relative">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <div class="text-5xl font-bold mb-2">{{ $booksBorrowed }}</div>
                <p class="text-lg text-purple-100 font-medium">Buku Sedang Dipinjam</p>
            </div>
            
            <a href="{{ route('user.peminjaman', ['status' => 'active']) }}" class="absolute bottom-6 right-8 text-white/80 hover:text-white flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                Lihat Detail <span class="text-lg">→</span>
            </a>
        </div>

        <!-- Riwayat Peminjaman -->
        <div
            class="group relative bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl p-8 text-white shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
            <div class="relative">
                <div class="flex items-start justify-between mb-8">
                    <div
                        class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="text-5xl font-bold mb-2">{{ $totalHistory }}</div>
                <p class="text-lg text-purple-100 font-medium">Total Riwayat Peminjaman</p>
            </div>
            
             <a href="{{ route('user.peminjaman', ['status' => 'history']) }}" class="absolute bottom-6 right-8 text-white/80 hover:text-white flex items-center gap-2 text-sm font-semibold group-hover:gap-4 transition-all">
                Lihat Riwayat <span class="text-lg">→</span>
            </a>
        </div>

    </div>

    <!-- RECENT ACTIVITY -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mt-10">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h2 class="text-xl font-bold text-gray-800">Aktivitas Terakhir</h2>
            <a href="{{ route('user.peminjaman', ['status' => 'history']) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Judul Buku</th>
                        <th class="px-6 py-4 font-semibold text-center">Tanggal Pinjam</th>
                         <th class="px-6 py-4 font-semibold text-center">Batas Kembali</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentActivity as $item)
                    <tr class="hover:bg-purple-50/30 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $item->book->title ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $item->book->author ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-600">{{ $item->tanggal_pinjam->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center text-gray-600">{{ $item->tanggal_kembali->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item->status == 'dipinjam')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                    Sedang Dipinjam
                                </span>
                            @elseif($item->status == 'dikembalikan')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                    Dikembalikan
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                    Terlambat
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p>Belum ada aktivitas peminjaman. Yuk mulai baca buku!</p>
                                <a href="{{ route('user.catalog') }}" class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                    Lihat Katalog Buku
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
