@extends('layouts.admin')

@section('title', 'Peminjaman | ReadSpace')

@php
    $statusParam = request('status', 'active');
    $title = $statusParam == 'history' ? '🕐 Riwayat Peminjaman' : '📌 Sedang Dipinjam';
@endphp

@section('header_title', $title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $title }}</h1>
            <p class="text-gray-500 text-sm">Kelola sirkulasi peminjaman buku perpustakaan</p>
        </div>

        @if(session('success'))
        <div class="mb-5 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl flex items-center justify-between">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 ml-4">✕</button>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl flex items-center justify-between">
            <span>❌ {{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 ml-4">✕</button>
        </div>
        @endif

        <!-- TABS -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('peminjaman', ['status' => 'active']) }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold transition-all
               {{ $statusParam != 'history'
                    ? 'bg-purple-600 text-white shadow-md shadow-purple-200'
                    : 'bg-white text-gray-500 border border-gray-200 hover:bg-purple-50 hover:text-purple-600' }}">
                📌 Sedang Dipinjam
            </a>
            <a href="{{ route('peminjaman', ['status' => 'history']) }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold transition-all
               {{ $statusParam == 'history'
                    ? 'bg-gray-700 text-white shadow-md shadow-gray-200'
                    : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 hover:text-gray-600' }}">
                🕐 Riwayat
            </a>
        </div>



        <!-- TABLE CARD -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Buku</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Batas Kembali</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($peminjaman as $index => $item)
                        <tr class="hover:bg-purple-50/40 transition-colors duration-150
                                   {{ $item->status == 'pending' ? 'bg-amber-50/40' : '' }}">
                            <td class="px-5 py-4 text-gray-400 text-sm">{{ $peminjaman->firstItem() + $index }}</td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-gray-900">{{ $item->user->nama_lengkap ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $item->user->email ?? '' }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-gray-800">{{ $item->book->title ?? '-' }}</div>
                                @if($item->book->code ?? false)
                                <div class="text-xs text-gray-400 font-mono">{{ $item->book->code }}</div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center text-gray-600 text-sm">
                                {{ $item->tanggal_pinjam->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 text-center text-sm
                                {{ ($item->status == 'dipinjam' && $item->tanggal_kembali->isPast()) ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                {{ $item->tanggal_kembali->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($item->status == 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                        <svg class="w-2.5 h-2.5 animate-pulse" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        Pending
                                    </span>
                                @elseif($item->status == 'dipinjam')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        Dipinjam
                                    </span>
                                @elseif($item->status == 'pengajuan_kembali')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                        <svg class="w-2.5 h-2.5 animate-bounce" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        Ajuan Kembali
                                    </span>
                                @elseif($item->status == 'dikembalikan')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        Dikembalikan
                                    </span>
                                @elseif($item->status == 'ditolak')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        Terlambat
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5 flex-wrap">

                                    {{-- ===== PENDING: Terima + Tolak ===== --}}
                                    @if($item->status == 'pending')
                                        <form action="{{ route('peminjaman.confirm', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                    class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold transition-colors border border-emerald-200">
                                                ✅ Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('peminjaman.reject', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Tolak permintaan ini?')">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                    class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold transition-colors border border-red-200">
                                                ❌ Tolak
                                            </button>
                                        </form>

                                    {{-- ===== DIPINJAM / TERLAMBAT: Bukti + Hapus ===== --}}
                                    @elseif(in_array($item->status, ['dipinjam', 'terlambat']))
                                        <button type="button"
                                                onclick="openBukti({{ json_encode([
                                                    'id'          => $item->id,
                                                    'peminjam'    => $item->user->nama_lengkap ?? '-',
                                                    'email'       => $item->user->email ?? '-',
                                                    'buku'        => $item->book->title ?? '-',
                                                    'kode'        => $item->book->code ?? '-',
                                                    'tgl_pinjam'  => $item->tanggal_pinjam->format('d M Y'),
                                                    'tgl_kembali' => $item->tanggal_kembali->format('d M Y'),
                                                    'status'      => $item->status,
                                                ]) }})"
                                                class="p-1.5 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-100 transition-colors" title="Lihat Bukti">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </button>
                                        <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>

                                    {{-- ===== PENGAJUAN KEMBALI: Konfirmasi Kembali + Bukti ===== --}}
                                    @elseif($item->status == 'pengajuan_kembali')
                                        <form action="{{ route('peminjaman.confirmReturn', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                    class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-teal-50 text-teal-700 hover:bg-teal-100 text-xs font-semibold transition-colors border border-teal-200">
                                                🔄 Konfirmasi Kembali
                                            </button>
                                        </form>
                                        <button type="button"
                                                onclick="openBukti({{ json_encode([
                                                    'id'          => $item->id,
                                                    'peminjam'    => $item->user->nama_lengkap ?? '-',
                                                    'email'       => $item->user->email ?? '-',
                                                    'buku'        => $item->book->title ?? '-',
                                                    'kode'        => $item->book->code ?? '-',
                                                    'tgl_pinjam'  => $item->tanggal_pinjam->format('d M Y'),
                                                    'tgl_kembali' => $item->tanggal_kembali->format('d M Y'),
                                                    'status'      => $item->status,
                                                ]) }})"
                                                class="p-1.5 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-100 transition-colors" title="Lihat Bukti">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </button>

                                    {{-- ===== RIWAYAT (dikembalikan / ditolak): Bukti + Hapus ===== --}}
                                    @else
                                        <button type="button"
                                                onclick="openBukti({{ json_encode([
                                                    'id'          => $item->id,
                                                    'peminjam'    => $item->user->nama_lengkap ?? '-',
                                                    'email'       => $item->user->email ?? '-',
                                                    'buku'        => $item->book->title ?? '-',
                                                    'kode'        => $item->book->code ?? '-',
                                                    'tgl_pinjam'  => $item->tanggal_pinjam->format('d M Y'),
                                                    'tgl_kembali' => $item->tanggal_kembali->format('d M Y'),
                                                    'status'      => $item->status,
                                                ]) }})"
                                                class="p-1.5 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-100 transition-colors" title="Lihat Bukti">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </button>
                                        <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <span class="text-5xl">📭</span>
                                    <p class="font-medium text-gray-500">Tidak ada data untuk ditampilkan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($peminjaman->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $peminjaman->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ===== BUKTI MODAL ===== -->
<div id="bukti-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
     onclick="if(event.target===this) closeBukti()">
    <div id="bukti-card" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-8 py-6">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center gap-3 text-white">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">📋</div>
                    <div>
                        <h2 class="text-lg font-bold">Bukti Peminjaman</h2>
                        <p class="text-purple-200 text-xs">ReadSpace Library System</p>
                    </div>
                </div>
                <button onclick="closeBukti()" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="px-8 py-6 space-y-4">
            <div class="bg-gray-50 rounded-xl px-5 py-3 flex items-center justify-between">
                <span class="text-xs text-gray-400">No. Transaksi</span>
                <span id="bukti-id" class="text-gray-800 font-bold text-sm font-mono"></span>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500 shrink-0">Peminjam</span>
                    <span id="bukti-peminjam" class="font-semibold text-gray-800 text-right"></span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-gray-500 shrink-0">Email</span>
                    <span id="bukti-email" class="font-semibold text-gray-800 text-right text-xs"></span>
                </div>
                <div class="border-t border-dashed border-gray-200 pt-3">
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500 shrink-0">Judul Buku</span>
                        <span id="bukti-buku" class="font-semibold text-gray-800 text-right"></span>
                    </div>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tgl Pinjam</span>
                    <span id="bukti-tgl-pinjam" class="font-semibold text-gray-800"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Batas Kembali</span>
                    <span id="bukti-tgl-kembali" class="font-semibold text-gray-800"></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Status</span>
                    <span id="bukti-status" class="px-3 py-1 rounded-full text-xs font-bold"></span>
                </div>
            </div>
            <p class="text-xs text-gray-400 text-center pt-1 border-t border-dashed border-gray-200">
                Harap kembalikan buku tepat waktu.
            </p>
        </div>
        <div class="px-8 pb-6 flex gap-3">
            <button onclick="printBukti()"
                    class="flex-1 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Bukti
            </button>
            <button onclick="closeBukti()"
                    class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openBukti(data) {
    const statusColors = {
        'pending':           'bg-amber-100 text-amber-700',
        'dipinjam':          'bg-blue-100 text-blue-700',
        'terlambat':         'bg-red-100 text-red-700',
        'pengajuan_kembali': 'bg-orange-100 text-orange-700',
        'dikembalikan':      'bg-green-100 text-green-700',
        'ditolak':           'bg-red-100 text-red-600',
    };
    const statusLabels = {
        'pending':           '⏳ Menunggu Konfirmasi',
        'dipinjam':          '📌 Sedang Dipinjam',
        'terlambat':         '⚠️ Terlambat',
        'pengajuan_kembali': '🔄 Menunggu Konfirmasi Kembali',
        'dikembalikan':      '✅ Dikembalikan',
        'ditolak':           '❌ Ditolak',
    };

    document.getElementById('bukti-id').textContent         = '#' + String(data.id).padStart(6, '0');
    document.getElementById('bukti-peminjam').textContent   = data.peminjam;
    document.getElementById('bukti-email').textContent      = data.email;
    document.getElementById('bukti-buku').textContent       = data.buku;
    document.getElementById('bukti-tgl-pinjam').textContent = data.tgl_pinjam;
    document.getElementById('bukti-tgl-kembali').textContent= data.tgl_kembali;

    const statusEl = document.getElementById('bukti-status');
    statusEl.textContent = statusLabels[data.status] ?? data.status;
    statusEl.className   = 'px-3 py-1 rounded-full text-xs font-bold ' + (statusColors[data.status] ?? 'bg-gray-100 text-gray-600');

    document.getElementById('bukti-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeBukti() {
    document.getElementById('bukti-modal').classList.add('hidden');
    document.body.style.overflow = '';
}
function printBukti() {
    const win = window.open('', '_blank', 'width=520,height=750');
    win.document.write(`<!DOCTYPE html>
<html><head><title>Bukti Peminjaman - ReadSpace</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Inter', sans-serif; background: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 24px; }
  .receipt { background: #fff; width: 360px; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
  .header { background: linear-gradient(135deg, #7c3aed, #2563eb); padding: 24px 28px; color: white; }
  .header .logo { display: flex; align-items: center; gap: 12px; margin-bottom: 4px; }
  .header .icon { width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
  .header h2 { font-size: 16px; font-weight: 700; }
  .header p { font-size: 11px; opacity: 0.7; margin-top: 2px; }
  .body { padding: 20px 24px; }
  .no-tx { background: #f9fafb; border-radius: 10px; padding: 10px 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
  .no-tx .label { font-size: 11px; color: #9ca3af; }
  .no-tx .value { font-size: 13px; font-weight: 700; font-family: monospace; color: #111; }
  .row { display: flex; justify-content: space-between; align-items: flex-start; padding: 8px 0; border-bottom: 1px dashed #e5e7eb; gap: 12px; }
  .row:last-child { border-bottom: none; }
  .row .label { font-size: 12px; color: #6b7280; white-space: nowrap; }
  .row .value { font-size: 12px; font-weight: 600; color: #111; text-align: right; }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; background: #dbeafe; color: #1d4ed8; }
  .divider { border-top: 1px dashed #e5e7eb; margin: 12px 0; }
  .footer-note { text-align: center; font-size: 11px; color: #9ca3af; padding-top: 12px; }
  .watermark { text-align: center; font-size: 10px; color: #d1d5db; padding: 12px; border-top: 1px solid #f3f4f6; letter-spacing: 1px; text-transform: uppercase; }
</style></head>
<body onload="window.print(); setTimeout(()=>window.close(),500)">
<div class="receipt">
  <div class="header">
    <div class="logo"><div class="icon">📋</div><div><h2>Bukti Peminjaman</h2><p>ReadSpace Library System</p></div></div>
  </div>
  <div class="body">
    <div class="no-tx"><span class="label">No. Transaksi</span><span class="value">${document.getElementById('bukti-id').textContent}</span></div>
    <div class="row"><span class="label">Peminjam</span><span class="value">${document.getElementById('bukti-peminjam').textContent}</span></div>
    <div class="row"><span class="label">Email</span><span class="value" style="font-size:11px">${document.getElementById('bukti-email').textContent}</span></div>
    <div class="divider"></div>
    <div class="row"><span class="label">Judul Buku</span><span class="value">${document.getElementById('bukti-buku').textContent}</span></div>
    <div class="row"><span class="label">Tgl Pinjam</span><span class="value">${document.getElementById('bukti-tgl-pinjam').textContent}</span></div>
    <div class="row"><span class="label">Batas Kembali</span><span class="value">${document.getElementById('bukti-tgl-kembali').textContent}</span></div>
    <div class="row"><span class="label">Status</span><span class="badge">${document.getElementById('bukti-status').textContent}</span></div>
    <p class="footer-note">Harap kembalikan buku tepat waktu.<br>Keterlambatan dikenakan sanksi perpustakaan.</p>
  </div>
  <div class="watermark">readspace · ${new Date().toLocaleDateString('id-ID')}</div>
</div>
</body></html>`);
    win.document.close();
}
</script>

@endsection