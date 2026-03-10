<!-- ================= SIDEBAR PETUGAS ================= -->
<aside class="w-72 fixed inset-y-0 left-0 bg-gradient-to-b from-purple-700 via-purple-800 to-purple-900
              hidden md:flex flex-col shadow-[8px_0_30px_rgba(0,0,0,0.25)] z-50">

    <!-- LOGO -->
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl">
                📚
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">ReadSpace</h1>
                <p class="text-xs text-purple-200">Petugas Panel</p>
            </div>
        </div>
    </div>

    <!-- NAV -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

        <!-- DASHBOARD -->
        <a href="{{ route('petugas.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group
           {{ request()->routeIs('petugas.dashboard')
                ? 'bg-white/20 text-white font-semibold'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="font-medium text-sm">Dashboard</span>
        </a>

        <!-- MANAJEMEN BUKU -->
        <details class="group"
            {{ request()->routeIs('books*', 'category*') ? 'open' : '' }}>
            <summary
                class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer
                       text-purple-200 hover:text-white hover:bg-white/10 transition list-none">

                <div class="flex items-center gap-3 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span class="font-medium text-sm">Manajemen Buku</span>
                </div>

                <!-- ICON PANAH -->
                <svg class="w-4 h-4 text-purple-300 transition-transform duration-300
                            group-open:rotate-90"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </summary>

            <div class="ml-4 mt-2 space-y-1">
                <a href="{{ route('books') }}"
                   class="block px-4 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('books')
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    📖 Daftar Buku
                </a>

                <a href="{{ route('category') }}"
                   class="block px-4 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('category')
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    📑 Kategori Buku
                </a>
            </div>
        </details>

        <!-- PEMINJAMAN -->
        <details class="group"
            {{ request()->routeIs('peminjaman*') || request()->routeIs('pengembalian*') ? 'open' : '' }}>
            <summary
                class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer
                       text-purple-200 hover:text-white hover:bg-white/10 transition list-none">

                <div class="flex items-center gap-3 group-hover:scale-105 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    <span class="font-medium text-sm">Monitoring Peminjaman</span>
                </div>

                <!-- ICON PANAH -->
                <svg class="w-4 h-4 text-purple-300 transition-transform duration-300
                            group-open:rotate-90"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </summary>

            <div class="ml-4 mt-2 space-y-1">
                <a href="{{ route('peminjaman', ['status' => 'active']) }}"
                   class="block px-4 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('peminjaman') && request('status') != 'history'
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    📌 Sedang Dipinjam
                </a>

                <a href="{{ route('pengembalian') }}"
                   class="block px-4 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('pengembalian')
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    🔄 Pengembalian
                </a>

                <a href="{{ route('peminjaman', ['status' => 'history']) }}"
                   class="block px-4 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('peminjaman') && request('status') == 'history'
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    🕐 Riwayat
                </a>
            </div>
        </details>

        <!-- LAPORAN -->
        <a href="{{ route('laporan') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group
           {{ request()->routeIs('laporan')
                ? 'bg-white/20 text-white font-semibold'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="font-medium text-sm">Laporan</span>
        </a>

        <!-- ULASAN -->
        <a href="{{ route('admin.ulasan') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group
           {{ request()->routeIs('admin.ulasan')
                ? 'bg-white/20 text-white font-semibold'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            <span class="font-medium text-sm">Ulasan Buku</span>
        </a>

    </nav>

  <!-- LOGOUT -->
<div class="p-6 border-t border-white/10">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button
            class="group w-full flex items-center justify-center gap-3 px-4 py-3.5 rounded-xl
                   bg-white/10 backdrop-blur-md text-purple-100 font-semibold
                   hover:bg-red-500/80 hover:text-white
                   transition-all duration-300 shadow-lg">

            <!-- ICON -->
            <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>

                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
