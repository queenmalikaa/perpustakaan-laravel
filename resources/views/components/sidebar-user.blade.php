<!-- ================= SIDEBAR USER ================= -->
<aside class="w-72 fixed inset-y-0 left-0 bg-gradient-to-b from-purple-700 via-purple-800 to-purple-900
              hidden md:flex flex-col shadow-[8px_0_30px_rgba(0,0,0,0.25)] z-50">

    <!-- LOGO -->
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl shadow-lg">
                📚
            </div>
            <div>
                <h1 class="text-xl font-bold text-white tracking-wide">ReadSpace</h1>
                <p class="text-xs text-purple-300 font-medium tracking-wider uppercase">User Area</p>
            </div>
        </div>
    </div>

    <!-- NAV -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

        <!-- DASHBOARD -->
        <a href="{{ route('user.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
           {{ request()->routeIs('user.dashboard')
                ? 'bg-white/20 text-white font-semibold shadow-sm'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- KATALOG BUKU -->
        <a href="{{ route('user.catalog') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
           {{ request()->routeIs('user.catalog')
                ? 'bg-white/20 text-white font-semibold shadow-sm'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span class="font-medium">Katalog Buku</span>
        </a>

        <!-- PEMINJAMAN -->
        <details class="group" {{ request()->routeIs('user.peminjaman*') ? 'open' : '' }}>
            <summary class="flex items-center justify-between px-4 py-3 rounded-xl cursor-pointer
                           text-purple-200 hover:bg-white/10 hover:text-white transition list-none">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    <span class="font-medium">Peminjaman Saya</span>
                </div>
                <svg class="w-4 h-4 text-purple-300 transition-transform duration-300 group-open:rotate-90"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </summary>

            <div class="ml-4 mt-1 space-y-1 border-l border-white/20 pl-3">
                <a href="{{ route('user.peminjaman', ['status' => 'active']) }}"
                   class="block px-4 py-2.5 rounded-lg text-sm transition-all
                   {{ request('status') == 'active'
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    📌 Sedang Dipinjam
                </a>
                <a href="{{ route('user.peminjaman', ['status' => 'history']) }}"
                   class="block px-4 py-2.5 rounded-lg text-sm transition-all
                   {{ request('status') == 'history'
                        ? 'bg-white/20 text-white font-semibold'
                        : 'text-purple-300 hover:bg-white/10 hover:text-white' }}">
                    🕐 Riwayat
                </a>
            </div>
        </details>

        <!-- KOLEKSI PRIBADI -->
        <a href="{{ route('user.collection') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
           {{ request()->routeIs('user.collection')
                ? 'bg-white/20 text-white font-semibold shadow-sm'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <span class="font-medium">Koleksi Pribadi</span>
        </a>

        <!-- EDIT PROFILE -->
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group
           {{ request()->routeIs('profile.edit')
                ? 'bg-white/20 text-white font-semibold shadow-sm'
                : 'text-purple-200 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="font-medium">Edit Profile</span>
        </a>

    </nav>

    <!-- USER INFO + LOGOUT -->
    <div class="p-4 border-t border-white/10">

        @auth
        <div class="flex items-center gap-3 px-3 py-3 mb-3 rounded-xl bg-white/10">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-pink-400 to-purple-500 flex items-center justify-center text-white text-sm font-bold shadow-md">
                {{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->username, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-white text-sm font-semibold truncate">{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</p>
                <p class="text-purple-300 text-xs truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        @endauth

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="group w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl
                           bg-white/10 backdrop-blur-md text-purple-100 font-semibold
                           hover:bg-red-500/80 hover:text-white
                           transition-all duration-300 shadow-lg">
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
