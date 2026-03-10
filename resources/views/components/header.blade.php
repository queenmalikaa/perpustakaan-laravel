<header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-30 ml-0 md:ml-72 transition-all duration-300">
    <div class="px-6 py-4 flex items-center justify-between">
        
        <!-- Mobile Menu Button (Optional, if you want to implement sidebar toggle later) -->
        <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Page Title (Breadcrumb style or simple title) -->
        <div class="flex items-center gap-2">
            <h2 class="text-xl font-semibold text-gray-800">
                @yield('header_title', 'Dashboard')
            </h2>
        </div>

        <!-- Right Side: User Profile -->
        <div class="flex items-center gap-4">

            <!-- User Profile -->
            <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->nama_lengkap ?? 'Pengguna' }}</p>
                    <p class="text-xs text-gray-500">
                        @if(Auth::user()->role == 'admin') Administrator
                        @elseif(Auth::user()->role == 'petugas') Petugas
                        @else Pembaca
                        @endif
                    </p>
                </div>
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center text-white font-bold shadow-md">
                    {{ substr(Auth::user()->nama_lengkap ?? 'A', 0, 1) }}
                </div>
            </div>

        </div>
    </div>
</header>
