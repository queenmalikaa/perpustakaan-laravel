@extends('layouts.admin')

@section('title', 'Pengembalian | ReadSpace')
@section('header_title', '🔄 Pengembalian Buku')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-1">🔄 Pengembalian Buku</h1>
            <p class="text-gray-500 text-sm">Konfirmasi pengajuan pengembalian dari peminjam</p>
        </div>

        @if(session('success'))
        <div class="mb-5 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl flex items-center justify-between">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600">✕</button>
        </div>
        @endif
        @if(session('error'))
        <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl flex items-center justify-between">
            <span>❌ {{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600">✕</button>
        </div>
        @endif

        <!-- TABS -->
        <div class="flex gap-2 mb-6">
            <a href="{{ route('pengembalian', ['tab' => 'pengajuan']) }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold transition-all
               {{ $tab != 'history'
                    ? 'bg-orange-500 text-white shadow-md shadow-orange-200'
                    : 'bg-white text-gray-500 border border-gray-200 hover:bg-orange-50 hover:text-orange-600' }}">
                🔄 Pengajuan Kembali
            </a>
            <a href="{{ route('pengembalian', ['tab' => 'history']) }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold transition-all
               {{ $tab == 'history'
                    ? 'bg-green-600 text-white shadow-md shadow-green-200'
                    : 'bg-white text-gray-500 border border-gray-200 hover:bg-green-50 hover:text-green-600' }}">
                ✅ Riwayat Pengembalian
            </a>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-orange-50 to-yellow-50 border-b border-gray-200">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Peminjam</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Buku</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Batas Kembali</th>
                            @if($tab == 'history')
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Dikembalikan</th>
                            @endif
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                {{ $tab == 'history' ? 'Status' : 'Aksi' }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($peminjaman as $index => $item)
                        <tr class="hover:bg-orange-50/30 transition-colors duration-150">
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
                                {{ $item->status != 'dikembalikan' && $item->tanggal_kembali->isPast() ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                {{ $item->tanggal_kembali->format('d M Y') }}
                            </td>
                            @if($tab == 'history')
                            <td class="px-5 py-4 text-center text-sm text-gray-600">
                                {{ $item->tanggal_dikembalikan ? \Carbon\Carbon::parse($item->tanggal_dikembalikan)->format('d M Y') : '-' }}
                            </td>
                            @endif
                            <td class="px-5 py-4 text-center">
                                @if($tab == 'history')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                        Dikembalikan
                                    </span>
                                @else
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Terima --}}
                                        <form action="{{ route('pengembalian.confirm', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                    class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gradient-to-r from-teal-500 to-green-500 text-white text-xs font-semibold hover:from-teal-600 hover:to-green-600 shadow-md shadow-teal-200 transition-all" title="Terima Pengembalian">
                                                ✅ Terima
                                            </button>
                                        </form>

                                        {{-- Tolak --}}
                                        <form action="{{ route('pengembalian.reject', $item->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit"
                                                    class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 text-white text-xs font-semibold hover:from-red-600 hover:to-rose-700 shadow-md shadow-red-200 transition-all" title="Tolak Pengembalian">
                                                ❌ Tolak
                                            </button>
                                        </form>

                                        {{-- Lihat Detail --}}
                                        <button type="button"
                                                onclick="openDetail({{ json_encode([
                                                    'id'          => $item->id,
                                                    'peminjam'    => $item->user->nama_lengkap ?? '-',
                                                    'email'       => $item->user->email ?? '-',
                                                    'buku'        => $item->book->title ?? '-',
                                                    'tgl_pinjam'  => $item->tanggal_pinjam->format('d M Y'),
                                                    'tgl_kembali' => $item->tanggal_kembali->format('d M Y'),
                                                ]) }})"
                                                class="p-2 rounded-xl bg-purple-50 text-purple-600 hover:bg-purple-100 transition-colors" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm2.21-2.21A8.5 8.5 0 1121 12a8.46 8.46 0 01-3.79-2.21z"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $tab == 'history' ? 7 : 6 }}" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <span class="text-5xl">{{ $tab == 'history' ? '📦' : '🎉' }}</span>
                                    <p class="font-medium text-gray-500">
                                        {{ $tab == 'history' ? 'Belum ada riwayat pengembalian.' : 'Tidak ada pengajuan pengembalian saat ini.' }}
                                    </p>
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

<!-- Detail Modal -->
<div id="detail-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
     onclick="if(event.target===this) closeDetail()">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-7 py-5 flex items-center justify-between">
            <div class="text-white">
                <h2 class="text-base font-bold">Detail Pengajuan Kembali</h2>
                <p class="text-orange-100 text-xs">ReadSpace Library System</p>
            </div>
            <button onclick="closeDetail()" class="text-white/70 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-7 py-5 space-y-3 text-sm">
            <div class="bg-gray-50 rounded-xl px-4 py-2 flex justify-between">
                <span class="text-gray-400 text-xs">No. Transaksi</span>
                <span id="det-id" class="font-bold font-mono text-sm text-gray-800"></span>
            </div>
            <div class="flex justify-between gap-3">
                <span class="text-gray-500">Peminjam</span>
                <span id="det-peminjam" class="font-semibold text-gray-800 text-right"></span>
            </div>
            <div class="flex justify-between gap-3">
                <span class="text-gray-500">Email</span>
                <span id="det-email" class="font-semibold text-gray-800 text-right text-xs"></span>
            </div>
            <div class="border-t border-dashed border-gray-200 pt-2 flex justify-between gap-3">
                <span class="text-gray-500">Judul Buku</span>
                <span id="det-buku" class="font-semibold text-gray-800 text-right"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tgl Pinjam</span>
                <span id="det-tgl-pinjam" class="font-semibold text-gray-800"></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Batas Kembali</span>
                <span id="det-tgl-kembali" class="font-semibold text-gray-800"></span>
            </div>
        </div>
        <div class="px-7 pb-6">
            <button onclick="closeDetail()"
                    class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openDetail(data) {
    document.getElementById('det-id').textContent         = '#' + String(data.id).padStart(6, '0');
    document.getElementById('det-peminjam').textContent   = data.peminjam;
    document.getElementById('det-email').textContent      = data.email;
    document.getElementById('det-buku').textContent       = data.buku;
    document.getElementById('det-tgl-pinjam').textContent = data.tgl_pinjam;
    document.getElementById('det-tgl-kembali').textContent= data.tgl_kembali;
    document.getElementById('detail-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeDetail() {
    document.getElementById('detail-modal').classList.add('hidden');
    document.body.style.overflow = '';
}
</script>

@endsection
