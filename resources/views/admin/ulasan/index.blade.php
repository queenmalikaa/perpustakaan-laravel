@extends('layouts.admin')

@section('title', 'Ulasan Buku | ReadSpace')
@section('header_title', 'Ulasan Buku')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-1">⭐ Ulasan Buku</h1>
            <p class="text-gray-500">Pantau ulasan dan rating yang diberikan pembaca.</p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center justify-between">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif

        <!-- STATS CARDS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Total Ulasan</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalUlasan }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Rata-rata Rating</p>
                <div class="flex items-end gap-2">
                    <p class="text-3xl font-bold text-amber-500">{{ number_format($avgRating, 1) }}</p>
                    <svg class="w-6 h-6 text-amber-400 mb-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Rating ⭐⭐⭐⭐⭐</p>
                <p class="text-3xl font-bold text-emerald-600">{{ $bintang5 }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Rating ⭐ (1 bintang)</p>
                <p class="text-3xl font-bold text-red-500">{{ $bintang1 }}</p>
            </div>
        </div>

        <!-- FILTER -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-6">
            <form method="GET" action="{{ route('admin.ulasan') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-52">
                    <input type="text" name="book" value="{{ request('book') }}"
                           placeholder="Cari judul buku..."
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm
                                  focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <select name="rating"
                        class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600
                               focus:outline-none focus:ring-2 focus:ring-purple-400">
                    <option value="">Semua Rating</option>
                    @for($i=5; $i>=1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                            {{ $i }} Bintang
                        </option>
                    @endfor
                </select>
                <button type="submit"
                        class="px-5 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl text-sm transition-all">
                    Cari
                </button>
                @if(request('book') || request('rating'))
                    <a href="{{ route('admin.ulasan') }}"
                       class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-medium rounded-xl text-sm transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pembaca</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Buku</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Rating</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Komentar</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($ulasan as $index => $item)
                        <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $ulasan->firstItem() + $index }}</td>

                            <!-- Pembaca -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-400 to-blue-500
                                                flex items-center justify-center text-white text-sm font-bold shrink-0">
                                        {{ strtoupper(substr($item->user->username ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $item->user->username ?? '-' }}</p>
                                        <p class="text-xs text-gray-400">{{ $item->user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Buku -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($item->book && $item->book->cover)
                                        <img src="{{ asset('images/books/' . $item->book->cover) }}"
                                             class="w-10 h-14 object-contain rounded-md border border-gray-100 bg-gray-50 shrink-0">
                                    @else
                                        <div class="w-10 h-14 rounded-md bg-purple-50 border border-purple-100 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm leading-tight line-clamp-2">
                                            {{ $item->book->title ?? '-' }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->book->author ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Rating Stars -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-0.5">
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $item->rating ? 'text-amber-400' : 'text-gray-200' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-400 mt-0.5 block">{{ $item->rating }}/5</span>
                            </td>

                            <!-- Komentar -->
                            <td class="px-6 py-4 max-w-xs">
                                @if($item->komentar)
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ $item->komentar }}</p>
                                @else
                                    <span class="text-xs text-gray-400 italic">Tidak ada komentar</span>
                                @endif
                            </td>

                            <!-- Tanggal -->
                            <td class="px-6 py-4 text-center text-sm text-gray-500 whitespace-nowrap">
                                {{ $item->created_at->format('d M Y') }}<br>
                                <span class="text-xs text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.ulasan.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                            title="Hapus Ulasan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-12 h-12 text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <p class="font-medium text-base">Belum ada ulasan</p>
                                    <p class="text-sm">Ulasan pembaca akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($ulasan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $ulasan->withQueryString()->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
