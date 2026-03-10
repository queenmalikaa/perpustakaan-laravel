<!-- ================= SIDEBAR ================= -->
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
                <p class="text-xs text-purple-200">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- NAV -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

        <!-- DASHBOARD -->
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center justify-between px-4 py-3 rounded-xl transition
           {{ request()->routeIs('admin.dashboard')
                ? 'bg-white/20 text-white font-semibold'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            Dashboard
        </a>

        <!-- MANAJEMEN BUKU -->
        <details class="group"
            {{ request()->routeIs('admin.books.index','admin.kategori_buku') ? 'open' : '' }}>
            <summary
                class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer
                       text-purple-200 hover:text-white hover:bg-white/10 transition list-none">

                <span class="font-medium text-sm">Manajemen Buku</span>

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
                   {{ request()->routeIs('admin.daftar_buku')
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    Daftar Buku
                </a>

                <a href="{{ route('category') }}"
                   class="block px-4 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('category')
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    Kategori Buku
                </a>
            </div>
        </details>

        <!-- MANAJEMEN AKUN -->
        <details class="group"
            {{ request()->routeIs('admin.staff_petugas','admin.pembaca') ? 'open' : '' }}>
            <summary
                class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer
                       text-purple-200 hover:text-white hover:bg-white/10 transition list-none">

                <span class="font-medium text-sm">Manajemen Akun</span>

                <!-- ICON PANAH -->
                <svg class="w-4 h-4 text-purple-300 transition-transform duration-300
                            group-open:rotate-90"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </summary>

            <div class="ml-4 mt-2 space-y-1">
                <a href="{{ route('account') }}"
                   class="block px-4 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('account')
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    Staff / Petugas
                </a>

                <a href="{{ route('account.pembaca') }}"
                   class="block px-4 py-2 rounded-lg text-sm transition
                   {{ request()->routeIs('account.pembaca')
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    Pembaca
                </a>
            </div>
        </details>

     
        <!-- PEMINJAMAN & LAPORAN -->
        <a href="{{ route('peminjaman') }}"
           class="block px-4 py-3 rounded-xl transition
           {{ request()->routeIs('peminjaman')
                ? 'bg-white/20 text-white font-semibold'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            Peminjaman
        </a>

        <a href="{{ route('laporan') }}"
           class="block px-4 py-3 rounded-xl transition
           {{ request()->routeIs('laporan')
                ? 'bg-white/20 text-white font-semibold'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            Laporan
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
        </form>
    </div>
</aside>
