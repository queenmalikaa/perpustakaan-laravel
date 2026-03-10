@extends('layouts.admin')

@section('title', 'Laporan | ReadSpace')
@section('header_title', 'Laporan Perpustakaan')

@section('content')
<!-- ===== PRINT STYLES ===== -->
<style>
@media print {
    /* Hide everything except content */
    aside, header, .no-print { display: none !important; }
    /* Remove sidebar margin */
    main, body, html { margin: 0 !important; padding: 0 !important; }
    .print-wrapper { margin: 0; padding: 0; }
    /* Table clean for print */
    .print-table thead { background: #f3f4f6 !important; -webkit-print-color-adjust: exact; }
    .status-badge { border: 1px solid #ccc; padding: 2px 6px; border-radius: 4px; font-size: 11px; }
    /* Print header info */
    .print-header { display: block !important; }
    /* Hide tabs/filter/buttons */
    .filter-section, .action-buttons, .tabs-container { display: none !important; }
    /* Show stat numbers cleanly */
    .stats-print { display: flex !important; gap: 16px; margin-bottom: 16px; }
    /* Make table full width */
    .print-table { width: 100% !important; border-collapse: collapse; }
    .print-table th, .print-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
}
@media screen {
    .print-header { display: none; }
    .stats-print { display: none; }
}
</style>

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 p-6 print-wrapper">
    <div class="max-w-7xl mx-auto">

        <!-- === SCREEN HEADER === -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 no-print">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">📊 Laporan Perpustakaan</h1>
                <p class="text-gray-500">Ringkasan aktivitas, statistik peminjaman, dan data buku</p>
            </div>
            <!-- PRINT BUTTON -->
            <button onclick="window.print()"
                    class="action-buttons inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600
                           text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:from-purple-700
                           hover:to-blue-700 transition-all font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Laporan
            </button>
        </div>

        <!-- === PRINT-ONLY HEADER (shows when printing) === -->
        <div class="print-header mb-6 border-b-2 border-gray-300 pb-4">
            <h1 class="text-2xl font-bold">
                Laporan {{ $type === 'buku' ? 'Data Buku' : ($type === 'pengembalian' ? 'Pengembalian' : ($type === 'anggota' ? 'Anggota' : 'Peminjaman')) }} - ReadSpace
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Dicetak pada: {{ now()->format('d M Y, H:i') }}
                @if(($type === 'peminjaman' || $type === 'pengembalian') && (request('start_date') || request('end_date')))
                    &nbsp;|&nbsp; Periode: {{ request('start_date', '-') }} s/d {{ request('end_date', '-') }}
                @endif
                @if($type === 'peminjaman' && request('status'))
                    &nbsp;|&nbsp; Status: {{ ucfirst(request('status')) }}
                @endif
                @if($type === 'buku' && request('category_id'))
                    &nbsp;|&nbsp; Kategori ID: {{ request('category_id') }}
                @endif
            </p>
        </div>

        <!-- TABS CONTAINER -->
        <div class="tabs-container mb-6 no-print">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a href="{{ route('laporan', ['type' => 'buku'] + request()->except('type')) }}"
                       class="{{ $type === 'buku' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Laporan Data Buku
                    </a>
                    <a href="{{ route('laporan', ['type' => 'peminjaman'] + request()->except('type')) }}"
                       class="{{ $type === 'peminjaman' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Laporan Peminjaman
                    </a>
                    <a href="{{ route('laporan', ['type' => 'pengembalian'] + request()->except('type')) }}"
                       class="{{ $type === 'pengembalian' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Laporan Pengembalian
                    </a>
                    <a href="{{ route('laporan', ['type' => 'anggota'] + request()->except('type')) }}"
                       class="{{ $type === 'anggota' ? 'border-purple-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Laporan Anggota
                    </a>
                </nav>
            </div>
        </div>

        <!-- FILTER -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100 filter-section no-print">
            <form action="{{ route('laporan') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Keep type in query -->
                <input type="hidden" name="type" value="{{ $type }}">

                @if($type === 'buku')
                    <!-- Filter for Buku -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori (ID)</label>
                        <input type="number" name="category_id" value="{{ request('category_id') }}" placeholder="Contoh: 1"
                               class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                    </div>
                @else
                    <!-- Filters for Peminjaman / Pengembalian -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal ({{ $type === 'pengembalian' ? 'Dikembalikan' : ($type === 'anggota' ? 'Daftar' : 'Pinjam') }})</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal ({{ $type === 'pengembalian' ? 'Dikembalikan' : ($type === 'anggota' ? 'Daftar' : 'Pinjam') }})</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all">
                    </div>

                    @if($type === 'peminjaman')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Peminjaman</label>
                        <select name="status"
                                class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all bg-white">
                            <option value="">Semua Status</option>
                            <option value="dipinjam"     {{ request('status') == 'dipinjam'     ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="terlambat"    {{ request('status') == 'terlambat'    ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>
                    @endif
                @endif

                <div class="flex items-end gap-2 @if($type === 'pengembalian' || $type === 'anggota') md:col-start-4 @elseif($type === 'buku') md:col-start-2 @endif">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium py-3 rounded-xl shadow hover:shadow-lg hover:from-purple-700 hover:to-blue-700 transition-all">
                        Filter Data
                    </button>
                    <a href="{{ route('laporan', ['type' => $type]) }}"
                       class="px-4 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-colors" title="Reset Filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </a>
                </div>
            </form>
        </div>

        <!-- STATISTIC CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            @if($type === 'buku')
                <!-- STATS for DATA BUKU -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Judul Buku</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_buku'] }}</h2>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Stok Tersedia</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_stok'] }}</h2>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                </div>

            @elseif($type === 'pengembalian')
                <!-- STATS for PENGEMBALIAN -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Buku Dikembalikan</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_dikembalikan'] }}</h2>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

            @elseif($type === 'anggota')
                <!-- STATS for ANGGOTA -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Anggota</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_anggota'] }}</h2>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>

            @else
                <!-- STATS for PEMINJAMAN (Default) -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Transaksi</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_peminjaman'] }}</h2>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Sedang Dipinjam</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_dipinjam'] }}</h2>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Buku Terlambat</p>
                        <h2 class="text-3xl font-bold text-gray-800">{{ $stats['total_terlambat'] }}</h2>
                    </div>
                    <div class="p-3 bg-red-50 rounded-xl">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            @endif
        </div>

        <!-- TABLE LAPORAN -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full print-table">
                    @if($type === 'buku')
                        <!-- Table for Buku -->
                        <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kode/Judul Buku</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Penulis / Penerbit</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tahun</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($data['books'] as $book)
                            <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $book->title }}</div>
                                    <div class="text-xs text-gray-400">{{ $book->code ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 text-sm">{{ $book->category->name ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-800">{{ $book->author }}</div>
                                    <div class="text-xs text-gray-500">{{ $book->publisher }}</div>
                                </td>
                                <td class="px-6 py-4 text-center text-gray-700 text-sm">{{ $book->tahun_terbit ?? '-' }}</td>
                                <td class="px-6 py-4 text-center font-medium {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->stock }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <p class="font-medium">Tidak ada data buku.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    @elseif($type === 'pengembalian')
                        <!-- Table for Pengembalian -->
                        <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tgl Dikembalikan</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($data['pengembalian'] as $item)
                            <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $item->user->nama_lengkap ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->user->email ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-medium">{{ $item->book->title ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-gray-600 text-sm">
                                    {{ $item->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600 text-sm font-semibold">
                                    {{ $item->tanggal_dikembalikan ? $item->tanggal_dikembalikan->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Dikembalikan
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <p class="font-medium">Tidak ada data pengembalian.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    @elseif($type === 'anggota')
                        <!-- Table for Anggota -->
                        <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Anggota</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">No Telepon</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tgl Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($data['anggota'] as $item)
                            <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $item->nama_lengkap ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-600 text-sm">{{ $item->email ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-gray-600 text-sm">{{ $item->telepon ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-gray-600 text-sm max-w-[200px] truncate" title="{{ $item->alamat }}">{{ $item->alamat ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-gray-600 text-sm font-semibold">{{ $item->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <p class="font-medium">Tidak ada data anggota.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    @else
                        <!-- Table for Peminjaman (Default) -->
                        <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Peminjam</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tgl Pinjam</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tgl Kembali</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($data['peminjaman'] as $item)
                            <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ $item->user->nama_lengkap ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->user->email ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-medium">{{ $item->book->title ?? '-' }}</td>
                                <td class="px-6 py-4 text-center text-gray-600 text-sm">
                                    {{ $item->tanggal_pinjam->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-600 text-sm">
                                    {{ $item->tanggal_kembali->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->status == 'dipinjam')
                                        <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Dipinjam
                                        </span>
                                    @elseif($item->status == 'dikembalikan')
                                        <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Dikembalikan
                                        </span>
                                    @elseif($item->status == 'pending')
                                        <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Pending
                                        </span>
                                    @elseif($item->status == 'return_requested')
                                        <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            Req. Return
                                        </span>
                                    @else
                                        <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Terlambat
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                    <p class="font-medium">Tidak ada data peminjaman.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    @endif
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
                <p class="text-sm text-gray-500">Menampilkan {{ isset($data[$type === 'buku' ? 'books' : ($type === 'pengembalian' ? 'pengembalian' : ($type === 'anggota' ? 'anggota' : 'peminjaman'))]) ? count($data[$type === 'buku' ? 'books' : ($type === 'pengembalian' ? 'pengembalian' : ($type === 'anggota' ? 'anggota' : 'peminjaman'))]) : 0 }} data</p>
                <!-- Print button at bottom -->
                <button onclick="window.print()"
                        class="no-print inline-flex items-center gap-2 text-sm text-purple-600 hover:text-purple-800 font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Laporan
                </button>
            </div>
        </div>

    </div>
</div>
@endsection