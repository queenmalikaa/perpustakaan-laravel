@extends('layouts.user')

@section('title', 'Peminjaman Saya | ReadSpace')
@section('header_title', 'Peminjaman Saya')

@section('content')
<div class="p-8 md:p-10">

    <!-- HEADER -->
    <div class="mb-8">
        <div class="h-1 w-20 bg-gradient-to-r from-purple-500 to-purple-700 rounded-full mb-4"></div>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Peminjaman Saya</h1>
        <p class="text-gray-500">Kelola dan pantau status peminjaman bukumu.</p>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-purple-50 border border-purple-200 text-purple-700 px-5 py-4 rounded-2xl">
        ✅ <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">
        ❌ <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <!-- TABS -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a href="{{ route('user.peminjaman', ['status' => 'pending']) }}"
           class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all
           {{ $status == 'pending'
                ? 'bg-amber-500 text-white shadow-md shadow-amber-200'
                : 'bg-white text-gray-500 border border-gray-200 hover:bg-amber-50 hover:text-amber-600' }}">
            ⏳ Menunggu Konfirmasi
        </a>
        <a href="{{ route('user.peminjaman', ['status' => 'active']) }}"
           class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all
           {{ $status == 'active'
                ? 'bg-purple-500 text-white shadow-md shadow-purple-200'
                : 'bg-white text-gray-500 border border-gray-200 hover:bg-purple-50 hover:text-purple-600' }}">
            📌 Sedang Dipinjam
        </a>
        <a href="{{ route('user.peminjaman', ['status' => 'history']) }}"
           class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all
           {{ $status == 'history'
                ? 'bg-gray-600 text-white shadow-md shadow-gray-200'
                : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50 hover:text-gray-600' }}">
            🕐 Riwayat
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Judul Buku</th>
                        <th class="px-6 py-4 font-semibold text-center">Tgl Pinjam</th>
                        <th class="px-6 py-4 font-semibold text-center">Batas Kembali</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                        <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($peminjaman as $item)
                    <tr class="hover:bg-purple-50/30 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($item->book && $item->book->cover)
                                    <img src="{{ asset('images/books/' . $item->book->cover) }}"
                                         class="w-10 h-14 object-contain rounded-lg border border-gray-100 bg-gray-50 shrink-0">
                                @else
                                    <div class="w-10 h-14 rounded-lg bg-purple-50 flex items-center justify-center shrink-0 text-purple-300 text-lg">📚</div>
                                @endif
                                <div>
                                    <div class="font-semibold text-gray-800">{{ $item->book->title ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->book->author ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-gray-600">
                            {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-center text-gray-600">
                            {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->status == 'pending')
                                <span class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                    ⏳ Menunggu
                                </span>
                            @elseif($item->status == 'dipinjam')
                                <span class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                    📌 Dipinjam
                                </span>
                            @elseif($item->status == 'pengajuan_kembali')
                                <span class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                    🔄 Validasi Kembali
                                </span>
                            @elseif($item->status == 'dikembalikan')
                                <span class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                    ✅ Dikembalikan
                                </span>
                            @elseif($item->status == 'ditolak')
                                <span class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600 border border-red-200">
                                    ❌ Ditolak
                                </span>
                            @else
                                <span class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600 border border-red-200">
                                    ⚠️ Terlambat
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2 flex-wrap">

                                {{-- TAB PENDING: Batalkan --}}
                                @if($item->status == 'pending')
                                    <form action="{{ route('user.peminjaman.cancel', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Batalkan permintaan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-semibold transition-colors">
                                            Batalkan
                                        </button>
                                    </form>

                                {{-- TAB ACTIVE: Lihat Bukti + Ajukan Pengembalian / badge menunggu --}}
                                @elseif($item->status == 'dipinjam' || $item->status == 'terlambat')
                                    <button type="button"
                                            onclick="openBukti({{ json_encode([
                                                'id'         => $item->id,
                                                'buku'       => $item->book->title ?? '-',
                                                'penulis'    => $item->book->author ?? '-',
                                                'kode'       => $item->book->code ?? '-',
                                                'peminjam'   => Auth::user()->nama_lengkap ?? Auth::user()->username,
                                                'tgl_pinjam' => $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-',
                                                'tgl_kembali'=> $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-',
                                                'status'     => $item->status,
                                            ]) }})"
                                            class="px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 text-xs font-semibold transition-colors">
                                        📋 Lihat Bukti
                                    </button>
                                    <form action="{{ route('user.peminjaman.requestReturn', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Ajukan pengembalian buku ini?')">
                                        @csrf
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-orange-50 text-orange-600 hover:bg-orange-100 text-xs font-semibold transition-colors">
                                            🔄 Ajukan Pengembalian
                                        </button>
                                    </form>

                                @elseif($item->status == 'pengajuan_kembali')
                                    <button type="button"
                                            onclick="openBukti({{ json_encode([
                                                'id'         => $item->id,
                                                'buku'       => $item->book->title ?? '-',
                                                'penulis'    => $item->book->author ?? '-',
                                                'kode'       => $item->book->code ?? '-',
                                                'peminjam'   => Auth::user()->nama_lengkap ?? Auth::user()->username,
                                                'tgl_pinjam' => $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-',
                                                'tgl_kembali'=> $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-',
                                                'status'     => $item->status,
                                            ]) }})"
                                            class="px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 text-xs font-semibold transition-colors">
                                        📋 Lihat Bukti
                                    </button>
                                    <span class="px-3 py-1.5 rounded-lg bg-gray-50 text-gray-400 text-xs font-medium border border-gray-100">
                                        ⏳ Menunggu admin...
                                    </span>

                                {{-- TAB RIWAYAT: Lihat Bukti + Beri Ulasan --}}
                                @elseif($item->status == 'dikembalikan')
                                    <button type="button"
                                            onclick="openBukti({{ json_encode([
                                                'id'         => $item->id,
                                                'buku'       => $item->book->title ?? '-',
                                                'penulis'    => $item->book->author ?? '-',
                                                'kode'       => $item->book->code ?? '-',
                                                'peminjam'   => Auth::user()->nama_lengkap ?? Auth::user()->username,
                                                'tgl_pinjam' => $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-',
                                                'tgl_kembali'=> $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-',
                                                'status'     => $item->status,
                                            ]) }})"
                                            class="px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 text-xs font-semibold transition-colors">
                                        📋 Lihat Bukti
                                    </button>
                                    {{-- Tombol Beri Ulasan --}}
                                    @if($item->book && in_array($item->book_id, $returnedBookIds))
                                        <button type="button"
                                                onclick="openUlasan({{ $item->book_id }}, '{{ addslashes($item->book->title ?? '') }}')"
                                                class="px-3 py-1.5 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 text-xs font-semibold transition-colors">
                                            ⭐ Beri Ulasan
                                        </button>
                                    @endif

                                @elseif($item->status == 'ditolak')
                                    {{-- Ditolak: tidak ada aksi --}}
                                    <span class="text-xs text-gray-400 italic">Tidak ada aksi</span>

                                @endif

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center text-gray-400 gap-3">
                                <span class="text-5xl">📭</span>
                                <p class="font-medium text-gray-500">
                                    @if($status == 'pending') Tidak ada permintaan yang menunggu.
                                    @elseif($status == 'active') Tidak ada buku yang sedang dipinjam.
                                    @else Belum ada riwayat peminjaman.
                                    @endif
                                </p>
                                <a href="{{ route('user.catalog') }}"
                                   class="px-5 py-2 bg-purple-500 text-white rounded-xl hover:bg-purple-600 transition text-sm font-semibold">
                                    Lihat Katalog Buku
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($peminjaman->hasPages())
        <div class="p-5 border-t border-gray-100">
            {{ $peminjaman->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>

<!-- ===== MODAL BUKTI PEMINJAMAN ===== -->
<div id="bukti-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
     onclick="if(event.target===this) closeBukti()">
    <div id="bukti-card" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-700 px-8 py-6 text-white">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">📋</div>
                    <h2 class="text-lg font-bold">Bukti Peminjaman</h2>
                </div>
                <button onclick="closeBukti()" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-purple-100 text-xs">ReadSpace Library System</p>
        </div>

        <!-- Receipt Body -->
        <div class="px-8 py-6 space-y-4">
            <!-- No. Transaksi -->
            <div class="bg-gray-50 rounded-2xl px-5 py-3 flex items-center justify-between">
                <span class="text-xs text-gray-400 font-medium">No. Transaksi</span>
                <span id="bukti-id" class="text-gray-800 font-bold text-sm font-mono"></span>
            </div>
            <!-- Buku -->
            <div class="flex items-start gap-3 py-1">
                <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Judul Buku</p>
                    <p id="bukti-buku" class="font-bold text-gray-800 text-sm leading-snug"></p>
                    <p id="bukti-penulis" class="text-xs text-gray-400"></p>
                </div>
            </div>
            <!-- Divider -->
            <div class="border-t border-dashed border-gray-200"></div>
            <!-- Info rows -->
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama Peminjam</span>
                    <span id="bukti-peminjam" class="font-semibold text-gray-800 text-right max-w-[55%]"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Pinjam</span>
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
            <!-- Divider -->
            <div class="border-t border-dashed border-gray-200"></div>
            <!-- Footer note -->
            <p class="text-xs text-gray-400 text-center leading-relaxed">
                Harap kembalikan buku tepat waktu.<br>
                Keterlambatan akan dikenakan sanksi sesuai peraturan perpustakaan.
            </p>
        </div>

        <!-- Footer Buttons -->
        <div class="px-8 pb-6 flex gap-3">
            <button onclick="printBukti()"
                    class="flex-1 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                🖨️ Print
            </button>
            <button onclick="closeBukti()"
                    class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ===== MODAL ULASAN ===== -->
<div id="ulasan-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
     onclick="if(event.target===this) closeUlasan()">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-yellow-400 to-orange-400 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 text-white">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">⭐</div>
                    <div>
                        <h2 class="text-lg font-bold">Beri Ulasan</h2>
                        <p id="ulasan-buku-title" class="text-yellow-100 text-xs"></p>
                    </div>
                </div>
                <button onclick="closeUlasan()" class="text-white/70 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Body -->
        <form id="ulasan-form" method="POST">
            @csrf
            <div class="px-8 py-6 space-y-5">
                <!-- Rating Stars -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Rating</label>
                    <div class="flex gap-2" id="star-group">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" data-value="{{ $i }}"
                                onclick="setRating({{ $i }})"
                                class="star-btn text-3xl transition-transform hover:scale-110 text-gray-300"
                                id="star-{{ $i }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="0">
                </div>
                <!-- Komentar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Komentar <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="komentar" rows="3"
                              class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-yellow-400 resize-none transition-all"
                              placeholder="Tulis pendapatmu tentang buku ini..."></textarea>
                </div>
            </div>
            <div class="px-8 pb-6 flex gap-3">
                <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-yellow-400 to-orange-400 hover:from-yellow-500 hover:to-orange-500 text-white font-semibold rounded-xl transition shadow-lg shadow-yellow-200">
                    Kirim Ulasan ✨
                </button>
                <button type="button" onclick="closeUlasan()"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ===== BUKTI =====
function openBukti(data) {
    const statusColors = {
        'dipinjam':          'bg-purple-100 text-purple-700',
        'terlambat':         'bg-red-100 text-red-700',
        'dikembalikan':      'bg-green-100 text-green-700',
        'pengajuan_kembali': 'bg-orange-100 text-orange-700',
        'ditolak':           'bg-red-100 text-red-600',
    };
    const statusLabels = {
        'dipinjam':          '📌 Sedang Dipinjam',
        'terlambat':         '⚠️ Terlambat',
        'dikembalikan':      '✅ Dikembalikan',
        'pengajuan_kembali': '🔄 Validasi Kembali',
        'ditolak':           '❌ Ditolak',
    };

    document.getElementById('bukti-id').textContent         = '#' + String(data.id).padStart(6, '0');
    document.getElementById('bukti-buku').textContent       = data.buku;
    document.getElementById('bukti-penulis').textContent    = data.penulis;
    document.getElementById('bukti-peminjam').textContent   = data.peminjam;
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
  .header { background: linear-gradient(135deg, #9333ea, #7e22ce); padding: 24px 28px; color: white; }
  .header .logo { display: flex; align-items: center; gap: 12px; margin-bottom: 4px; }
  .header .icon { width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
  .header h2 { font-size: 16px; font-weight: 700; }
  .header p { font-size: 11px; opacity: 0.7; margin-top: 2px; }
  .body { padding: 20px 24px; }
  .no-tx { background: #f9fafb; border-radius: 10px; padding: 10px 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
  .no-tx .label { font-size: 11px; color: #9ca3af; }
  .no-tx .value { font-size: 14px; font-weight: 700; font-family: monospace; color: #111; }
  .book-title { font-size: 14px; font-weight: 700; color: #111; }
  .book-author { font-size: 11px; color: #9ca3af; margin-top: 2px; }
  .divider { border-top: 1px dashed #e5e7eb; margin: 12px 0; }
  .row { display: flex; justify-content: space-between; gap: 12px; padding: 6px 0; }
  .row .label { font-size: 12px; color: #6b7280; }
  .row .value { font-size: 12px; font-weight: 600; text-align: right; color: #111; }
  .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; background: #ede9fe; color: #7c3aed; }
  .footer-note { text-align: center; font-size: 10px; color: #9ca3af; margin-top: 14px; line-height: 1.6; }
  .watermark { text-align: center; font-size: 10px; color: #e5e7eb; padding: 10px; border-top: 1px solid #f3f4f6; letter-spacing: 2px; text-transform: uppercase; }
</style></head>
<body onload="window.print(); setTimeout(()=>window.close(),500)">
<div class="receipt">
  <div class="header">
    <div class="logo"><div class="icon">📋</div><div><h2>Bukti Peminjaman</h2><p>ReadSpace Library System</p></div></div>
  </div>
  <div class="body">
    <div class="no-tx"><span class="label">No. Transaksi</span><span class="value">${document.getElementById('bukti-id').textContent}</span></div>
    <div class="book-title">${document.getElementById('bukti-buku').textContent}</div>
    <div class="book-author">${document.getElementById('bukti-penulis').textContent}</div>
    <div class="divider"></div>
    <div class="row"><span class="label">Nama Peminjam</span><span class="value">${document.getElementById('bukti-peminjam').textContent}</span></div>
    <div class="row"><span class="label">Tanggal Pinjam</span><span class="value">${document.getElementById('bukti-tgl-pinjam').textContent}</span></div>
    <div class="row"><span class="label">Batas Kembali</span><span class="value">${document.getElementById('bukti-tgl-kembali').textContent}</span></div>
    <div class="row"><span class="label">Status</span><span class="badge">${document.getElementById('bukti-status').textContent}</span></div>
    <p class="footer-note">Harap kembalikan buku tepat waktu.<br>Keterlambatan akan dikenakan sanksi sesuai peraturan perpustakaan.</p>
  </div>
  <div class="watermark">readspace · ${new Date().toLocaleDateString('id-ID')}</div>
</div>
</body></html>`);
    win.document.close();
}

// ===== ULASAN =====
let currentRating = 0;
function openUlasan(bookId, bookTitle) {
    const baseUrl = '{{ url("/user/catalog") }}';
    document.getElementById('ulasan-form').action = baseUrl + '/' + bookId + '/ulasan';
    document.getElementById('ulasan-buku-title').textContent = bookTitle;
    currentRating = 0;
    setRating(0);
    document.getElementById('ulasan-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeUlasan() {
    document.getElementById('ulasan-modal').classList.add('hidden');
    document.body.style.overflow = '';
}
function setRating(val) {
    currentRating = val;
    document.getElementById('rating-input').value = val;
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById('star-' + i);
        star.className = 'star-btn text-3xl transition-transform hover:scale-110 ' + (i <= val ? 'text-yellow-400' : 'text-gray-300');
    }
}
</script>

@endsection
