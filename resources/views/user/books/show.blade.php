@extends('layouts.user')

@section('title', $book->title . ' | ReadSpace')
@section('header_title', 'Detail Buku')

@section('content')
<div class="p-8 md:p-10 max-w-6xl mx-auto">

    <!-- FLASH -->
    @if(session('success'))
    <div id="fl-ok" class="mb-6 flex items-center gap-3 bg-purple-50 border border-purple-200 text-purple-700 px-5 py-4 rounded-xl">
        ✅ <span class="font-medium">{{ session('success') }}</span>
        <button onclick="document.getElementById('fl-ok').remove()" class="ml-auto">✕</button>
    </div>
    @endif
    @if(session('error'))
    <div id="fl-err" class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl">
        ❌ <span class="font-medium">{{ session('error') }}</span>
        <button onclick="document.getElementById('fl-err').remove()" class="ml-auto">✕</button>
    </div>
    @endif

    <!-- BREADCRUMB -->
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6">
        <a href="{{ route('user.catalog') }}" class="hover:text-purple-500 transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Katalog
        </a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 font-medium truncate max-w-xs">{{ $book->title }}</span>
    </nav>

    <!-- ====== MAIN CARD ====== -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="flex flex-col md:flex-row">

            <!-- COVER -->
            <div class="md:w-72 lg:w-80 flex-shrink-0">
                @if($book->cover)
                    <img src="{{ asset('images/books/' . $book->cover) }}"
                         alt="{{ $book->title }}"
                         class="w-full h-80 md:h-full object-cover">
                @else
                    <div class="w-full h-80 md:h-full bg-gradient-to-br from-emerald-50 via-blue-50 to-cyan-100
                                flex items-center justify-center">
                        <svg class="w-24 h-24 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- DETAIL -->
            <div class="flex-1 p-8">

                <!-- Badges -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @if($book->category)
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-50 text-purple-700 border border-purple-200">
                            {{ $book->category->name }}
                        </span>
                    @endif
                    @if($book->stock > 0)
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-50 text-green-700 border border-green-200">
                            ✅ Tersedia — {{ $book->stock }} stok
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-50 text-red-700 border border-red-200">
                            ❌ Stok Habis
                        </span>
                    @endif
                    @if($activeLoan)
                        @if($activeLoan->status == 'pending')
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-amber-50 text-amber-700 border border-amber-200">
                            ⏳ Menunggu Konfirmasi
                        </span>
                        @else
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-200">
                            📌 Sedang Kamu Pinjam
                        </span>
                        @endif
                    @endif
                </div>

                <!-- Rating -->
                @if($ulasanList->count() > 0)
                <div class="flex items-center gap-2 mb-3">
                    <div class="flex">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-gray-200' }}"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ number_format($avgRating, 1) }}</span>
                    <span class="text-sm text-gray-400">({{ $ulasanList->count() }} ulasan)</span>
                </div>
                @endif

                <h1 class="text-3xl font-bold text-gray-900 leading-tight mb-1">{{ $book->title }}</h1>
                <p class="text-gray-500 text-lg mb-6">oleh <span class="font-semibold text-gray-700">{{ $book->author }}</span></p>

                <!-- Meta Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6 p-5 bg-gray-50 rounded-2xl">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">Penerbit</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $book->publisher ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">Tahun Terbit</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $book->tahun_terbit ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">Kode Buku</p>
                        <p class="text-sm font-semibold text-gray-800 font-mono">{{ $book->code ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">Kategori</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $book->category->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">Stok</p>
                        <p class="text-sm font-semibold {{ $book->stock > 0 ? 'text-purple-600' : 'text-red-500' }}">
                            {{ $book->stock }} buku
                        </p>
                    </div>
                    @if($activeLoan)
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide font-medium mb-1">Batas Kembali</p>
                        <p class="text-sm font-semibold text-amber-600">
                            {{ \Carbon\Carbon::parse($activeLoan->tanggal_kembali)->format('d M Y') }}
                        </p>
                    </div>
                    @endif
                </div>

                @if($book->description)
                <div class="mb-8">
                    <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Deskripsi</h2>
                    <p class="text-gray-600 leading-relaxed text-sm">{{ $book->description }}</p>
                </div>
                @endif

                <!-- ACTIONS -->
                <div class="flex flex-wrap gap-3">
                    @if($activeLoan)
                        @if($activeLoan->status == 'pending')
                        <div class="h-12 px-5 flex-1 bg-amber-50 border-2 border-amber-200 text-amber-700 font-bold
                                    rounded-2xl flex items-center justify-center gap-2 text-sm min-w-0">
                            <svg class="w-4 h-4 shrink-0 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="truncate">Menunggu Konfirmasi Admin</span>
                        </div>
                        @else
                        <div class="h-12 px-5 flex-1 bg-blue-50 border-2 border-blue-200 text-blue-700 font-bold
                                    rounded-2xl flex items-center justify-center gap-2 text-sm min-w-0">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="truncate">Sedang Dipinjam</span>
                        </div>
                        @endif
                    @elseif($book->stock > 0)
                        <form method="POST" action="{{ route('user.pinjam', $book->id) }}" class="flex-1 min-w-0">
                            @csrf
                            <button type="submit"
                                    class="w-full h-12 px-5 bg-gradient-to-r from-purple-500 to-purple-700
                                           hover:from-emerald-600 hover:to-purple-600 text-white font-bold
                                           rounded-2xl transition-all duration-200 shadow-lg shadow-purple-200
                                           flex items-center justify-center gap-2 text-sm">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Pinjam Sekarang
                            </button>
                        </form>
                    @else
                        <button disabled
                                class="flex-1 h-12 px-5 bg-gray-100 text-gray-400 font-bold rounded-2xl
                                       cursor-not-allowed flex items-center justify-center gap-2 text-sm">
                            Stok Habis
                        </button>
                    @endif

                    <!-- Toggle Koleksi -->
                    <form method="POST" action="{{ route('user.koleksi.toggle', $book->id) }}">
                        @csrf
                        <button type="submit"
                                class="h-12 px-5 font-bold rounded-2xl transition-all duration-200 flex items-center gap-2 text-sm whitespace-nowrap
                                       {{ $inKoleksi
                                          ? 'bg-purple-500 text-white hover:bg-purple-600'
                                          : 'bg-gray-50 border-2 border-gray-200 text-gray-600 hover:bg-purple-500 hover:text-white hover:border-blue-500' }}">
                            <svg class="w-5 h-5 shrink-0" fill="{{ $inKoleksi ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            {{ $inKoleksi ? 'Hapus Koleksi' : 'Simpan Koleksi' }}
                        </button>
                    </form>

                    <a href="{{ route('user.catalog') }}"
                       class="h-12 px-5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl
                              transition-all flex items-center gap-2 text-sm whitespace-nowrap">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== ULASAN / REVIEW ====== -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            Ulasan Pembaca
            @if($ulasanList->count() > 0)
                <span class="text-sm font-normal text-gray-400">({{ $ulasanList->count() }} ulasan)</span>
            @endif
        </h2>

        <!-- FORM ULASAN -->
        <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h3 class="font-bold text-gray-700 mb-4 text-sm">
                {{ $myUlasan ? '✏️ Edit Ulasanmu' : '💬 Tulis Ulasan' }}
            </h3>
            <form method="POST" action="{{ route('user.ulasan.submit', $book->id) }}">
                @csrf

                <!-- Star Rating Picker -->
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-2 font-medium">Rating</p>
                    <div class="flex gap-1" id="star-picker">
                        @for($i=1; $i<=5; $i++)
                        <label class="cursor-pointer">
                            <input type="radio" name="rating" value="{{ $i }}" class="sr-only"
                                   {{ ($myUlasan && $myUlasan->rating == $i) || (!$myUlasan && $i == 5) ? 'checked' : '' }}>
                            <svg class="w-8 h-8 star-icon transition-colors duration-150
                                        {{ ($myUlasan && $myUlasan->rating >= $i) || (!$myUlasan && $i <= 5) ? 'text-amber-400' : 'text-gray-200' }}"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </label>
                        @endfor
                    </div>
                </div>

                <!-- Komentar -->
                <div class="mb-4">
                    <textarea name="komentar" rows="3" maxlength="1000"
                              placeholder="Bagikan pendapatmu tentang buku ini..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                     focus:outline-none focus:ring-2 focus:ring-purple-400 resize-none">{{ $myUlasan ? $myUlasan->komentar : '' }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold
                                   rounded-xl text-sm transition-all">
                        {{ $myUlasan ? 'Update Ulasan' : 'Kirim Ulasan' }}
                    </button>
                    @if($myUlasan)
                        <form method="POST" action="{{ route('user.ulasan.delete', $book->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-6 py-2.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-500
                                           border border-red-200 hover:border-red-500 font-semibold rounded-xl text-sm transition-all"
                                    onclick="return confirm('Hapus ulasanmu?')">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </form>
        </div>

        <!-- DAFTAR ULASAN -->
        @if($ulasanList->isEmpty())
            <div class="text-center py-10 text-gray-400">
                <div class="text-4xl mb-3">💬</div>
                <p>Belum ada ulasan. Jadilah yang pertama memberi ulasan!</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($ulasanList as $ul)
                <div class="flex gap-4 p-5 rounded-2xl {{ $ul->user_id == Auth::id() ? 'bg-purple-50 border border-purple-100' : 'bg-gray-50' }}">
                    <!-- Avatar -->
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-purple-500
                                flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($ul->user->nama_lengkap ?? $ul->user->username ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1.5 flex-wrap">
                            <span class="font-semibold text-gray-800 text-sm">
                                {{ $ul->user->nama_lengkap ?? $ul->user->username ?? 'Pengguna' }}
                                @if($ul->user_id == Auth::id())
                                    <span class="ml-1 text-xs text-purple-600 font-medium">(Kamu)</span>
                                @endif
                            </span>
                            <!-- Stars -->
                            <div class="flex">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $ul->rating ? 'text-amber-400' : 'text-gray-200' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-400">{{ $ul->created_at->diffForHumans() }}</span>
                        </div>
                        @if($ul->komentar)
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $ul->komentar }}</p>
                        @else
                            <p class="text-sm text-gray-400 italic">Tidak ada komentar.</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- ====== BUKU SERUPA ====== -->
    @if($related->count() > 0)
    <div>
        <h2 class="text-xl font-bold text-gray-800 mb-5">Buku Serupa</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($related as $rel)
            <a href="{{ route('user.catalog.show', $rel->id) }}"
               class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-0.5
                       transition-all duration-300 overflow-hidden group">
                <div class="h-40 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                    @if($rel->cover)
                        <img src="{{ asset('images/books/' . $rel->cover) }}"
                             alt="{{ $rel->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-emerald-50 to-purple-50">
                            <svg class="w-12 h-12 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 text-sm leading-tight line-clamp-2 group-hover:text-purple-600 transition-colors">
                        {{ $rel->title }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1 truncate">{{ $rel->author }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<!-- Star picker script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = document.querySelectorAll('#star-picker label');
    const inputs = document.querySelectorAll('#star-picker input[type=radio]');

    labels.forEach((label, idx) => {
        label.addEventListener('mouseenter', () => {
            labels.forEach((l, i) => {
                l.querySelector('svg').classList.toggle('text-amber-400', i <= idx);
                l.querySelector('svg').classList.toggle('text-gray-200', i > idx);
            });
        });
        label.addEventListener('click', () => {
            labels.forEach((l, i) => {
                l.querySelector('svg').classList.toggle('text-amber-400', i <= idx);
                l.querySelector('svg').classList.toggle('text-gray-200', i > idx);
            });
        });
    });

    const picker = document.getElementById('star-picker');
    picker.addEventListener('mouseleave', () => {
        const checked = document.querySelector('#star-picker input[type=radio]:checked');
        const val = checked ? parseInt(checked.value) : 5;
        labels.forEach((l, i) => {
            l.querySelector('svg').classList.toggle('text-amber-400', i < val);
            l.querySelector('svg').classList.toggle('text-gray-200', i >= val);
        });
    });
});
</script>
@endsection
