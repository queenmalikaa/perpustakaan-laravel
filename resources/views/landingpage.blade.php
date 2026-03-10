<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadSpace — Perpustakaan Digital Modern</title>
    <meta name="description" content="Akses koleksi buku perpustakaan, pinjam online, dan kelola riwayat peminjaman dengan ReadSpace.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }

        /* Navbar scroll effect */
        #navbar { transition: all 0.3s ease; }
        #navbar.scrolled {
            background: rgba(255,255,255,0.97);
            box-shadow: 0 4px 24px rgba(102,126,234,0.10);
        }

        /* Gradient helpers */
        .g-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .g-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }

        /* Hero blobs */
        .blob { position:absolute; border-radius:50%; filter:blur(80px); opacity:0.45;
                animation: blob 8s infinite ease-in-out; }
        @keyframes blob {
            0%,100% { transform: translate(0,0) scale(1); }
            33%      { transform: translate(30px,-50px) scale(1.1); }
            66%      { transform: translate(-20px,20px) scale(0.9); }
        }

        /* Book card hover */
        .book-card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .book-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(102,126,234,0.18); }

        /* Step connector line */
        .step-line::after {
            content: '';
            position: absolute;
            top: 32px; right: -50%;
            width: 100%; height: 2px;
            background: linear-gradient(90deg, #c4b5fd, #93c5fd);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

{{-- ===========================
     NAVBAR
     =========================== --}}
<nav id="navbar" class="fixed w-full z-50 bg-white/80 backdrop-blur-xl border-b border-white/40">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between items-center h-[72px]">

            {{-- Logo --}}
            <a href="#beranda" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 g-bg rounded-xl flex items-center justify-center text-white text-lg shadow-lg shadow-purple-200 group-hover:scale-105 transition-transform">
                    📚
                </div>
                <span class="text-xl font-extrabold tracking-tight">
                    <span class="g-text">Read</span><span class="text-gray-800">Space</span>
                </span>
            </a>

            {{-- Nav links (desktop) --}}
            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-gray-500">
                <a href="#beranda" class="hover:text-purple-600 transition-colors">Beranda</a>
                <a href="#koleksi" class="hover:text-purple-600 transition-colors">Koleksi</a>
                <a href="#cara" class="hover:text-purple-600 transition-colors">Cara Pinjam</a>
                <a href="#tentang" class="hover:text-purple-600 transition-colors">Tentang</a>
            </div>

            {{-- Auth buttons --}}
            @auth
                @php
                    $role = Auth::user()->role;
                    $dashboardRoute = $role === 'admin' ? 'admin.dashboard'
                                    : ($role === 'petugas' ? 'petugas.dashboard' : 'user.dashboard');
                @endphp
                <div class="flex items-center gap-3">
                    <a href="{{ route($dashboardRoute) }}"
                       class="px-5 py-2.5 g-bg text-white text-sm font-semibold rounded-xl shadow-md shadow-purple-300/40 hover:opacity-90 transition-opacity">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-red-500 hover:bg-red-50 rounded-xl transition-colors border border-gray-200">
                            Keluar
                        </button>
                    </form>
                </div>
            @else
                <div class="hidden md:flex items-center gap-3">
                    <a href="/login"
                       class="px-5 py-2.5 text-sm font-semibold text-purple-600 hover:bg-purple-50 rounded-xl transition-colors">
                        Masuk
                    </a>
                    <a href="/register"
                       class="px-5 py-2.5 g-bg text-white text-sm font-semibold rounded-xl shadow-md shadow-purple-300/40 hover:opacity-90 transition-opacity">
                        Daftar Gratis
                    </a>
                </div>
            @endauth

            {{-- Mobile menu btn --}}
            <button id="mobile-btn" class="md:hidden p-2 text-gray-500 hover:text-purple-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="md:hidden hidden pb-4 flex flex-col gap-3 text-sm font-semibold text-gray-600">
            <a href="#beranda" class="hover:text-purple-600 py-2 border-b border-gray-100">Beranda</a>
            <a href="#koleksi" class="hover:text-purple-600 py-2 border-b border-gray-100">Koleksi</a>
            <a href="#cara"    class="hover:text-purple-600 py-2 border-b border-gray-100">Cara Pinjam</a>
            <a href="#tentang" class="hover:text-purple-600 py-2 border-b border-gray-100">Tentang</a>
            @guest
            <div class="flex gap-3 mt-2">
                <a href="/login"    class="flex-1 py-2.5 text-center text-purple-600 border border-purple-200 rounded-xl hover:bg-purple-50 transition">Masuk</a>
                <a href="/register" class="flex-1 py-2.5 text-center g-bg text-white rounded-xl hover:opacity-90 transition">Daftar</a>
            </div>
            @endguest
        </div>
    </div>
</nav>

{{-- ===========================
     HERO
     =========================== --}}
<section id="beranda" class="relative min-h-screen flex items-center pt-24 pb-16 overflow-hidden bg-white">
    {{-- Blobs --}}
    <div class="blob w-[500px] h-[500px] bg-purple-300 -top-32 -left-32" style="animation-delay:0s"></div>
    <div class="blob w-[400px] h-[400px] bg-blue-300 bottom-0 right-0" style="animation-delay:3s"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full">
        <div class="grid md:grid-cols-2 gap-14 items-center">

            {{-- Text --}}
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-8">
                    ✨ Perpustakaan Digital ReadSpace
                </div>
                <h1 class="text-5xl md:text-6xl font-black leading-[1.1] mb-6">
                    Baca, Pinjam,<br>
                    <span class="g-text">Kapan Saja</span>
                </h1>
                <p class="text-lg text-gray-500 mb-10 leading-relaxed max-w-md">
                    Akses koleksi buku perpustakaan, ajukan peminjaman online, dan pantau status peminjaman kamu — semua di satu tempat.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="/register"
                       class="px-8 py-4 g-bg text-white rounded-2xl font-bold text-sm shadow-xl shadow-purple-400/30 hover:opacity-90 transition-opacity">
                        Mulai Sekarang →
                    </a>
                    <a href="#koleksi"
                       class="px-8 py-4 border-2 border-purple-200 text-purple-700 rounded-2xl font-bold text-sm hover:bg-purple-50 transition-colors">
                        Lihat Koleksi
                    </a>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-6 mt-12 pt-10 border-t border-gray-100">
                    <div>
                        <div class="text-3xl font-black g-text">{{ \App\Models\Book::count() }}+</div>
                        <div class="text-gray-500 text-sm mt-1">Koleksi Buku</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black g-text">{{ \App\Models\User::where('role','user')->count() }}+</div>
                        <div class="text-gray-500 text-sm mt-1">Anggota</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black g-text">{{ \App\Models\Peminjaman::where('status','dikembalikan')->count() }}+</div>
                        <div class="text-gray-500 text-sm mt-1">Buku Dikembalikan</div>
                    </div>
                </div>
            </div>

            {{-- Illustration: stacked book covers from DB --}}
            <div class="hidden md:flex items-center justify-center relative">
                {{-- Decorative ring --}}
                <div class="absolute w-80 h-80 rounded-full border-2 border-dashed border-purple-200 animate-spin" style="animation-duration:30s"></div>
                <div class="absolute w-60 h-60 rounded-full bg-gradient-to-br from-purple-100 to-blue-100 opacity-70"></div>

                {{-- Book mosaic --}}
                <div class="relative z-10 grid grid-cols-3 gap-3 p-4">
                    @php $heroBooks = $featuredBooks->take(6); @endphp
                    @foreach($heroBooks as $b)
                    <div class="w-24 h-32 rounded-xl overflow-hidden shadow-lg bg-gradient-to-br from-purple-50 to-blue-50 border border-white
                                {{ $loop->index % 2 == 0 ? '-rotate-3' : 'rotate-2' }} hover:rotate-0 transition-transform duration-300">
                        @if($b->cover)
                            <img src="{{ asset('images/books/' . $b->cover) }}" alt="{{ $b->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-3xl bg-gradient-to-br
                                {{ ['from-purple-400 to-blue-500','from-emerald-400 to-teal-500','from-pink-400 to-rose-500','from-amber-400 to-orange-500','from-indigo-400 to-purple-500','from-cyan-400 to-blue-500'][$loop->index % 6] }}">
                                📚
                            </div>
                        @endif
                    </div>
                    @endforeach
                    @for($i = $heroBooks->count(); $i < 6; $i++)
                    <div class="w-24 h-32 rounded-xl shadow-lg flex items-center justify-center text-3xl
                                bg-gradient-to-br from-purple-100 to-blue-100 border border-white
                                {{ $i % 2 == 0 ? '-rotate-3' : 'rotate-2' }}">
                        📖
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===========================
     KOLEKSI BUKU (Real DB data)
     =========================== --}}
<section id="koleksi" class="py-24 bg-gradient-to-br from-gray-50 to-purple-50/40">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-5">
                📚 Koleksi Tersedia
            </div>
            <h2 class="text-4xl md:text-5xl font-black mb-4">
                Buku <span class="g-text">Pilihan</span>
            </h2>
            <p class="text-gray-500 max-w-xl mx-auto">
                Temukan buku-buku terbaik dari koleksi perpustakaan kami. Pinjam langsung dari halaman katalog.
            </p>
        </div>

        @if($featuredBooks->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredBooks as $book)
            <div class="book-card bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm group">
                {{-- Cover --}}
                <div class="relative h-44 bg-gradient-to-br from-purple-50 to-blue-50 overflow-hidden">
                    @if($book->cover)
                        <img src="{{ asset('images/books/' . $book->cover) }}"
                             alt="{{ $book->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-5xl
                                    bg-gradient-to-br
                                    {{ ['from-purple-100 to-purple-200','from-blue-100 to-blue-200','from-emerald-100 to-emerald-200','from-amber-100 to-amber-200','from-rose-100 to-rose-200','from-cyan-100 to-cyan-200', 'from-indigo-100 to-indigo-200','from-teal-100 to-teal-200'][$loop->index % 8] }}">
                            📚
                        </div>
                    @endif
                    {{-- Stock badge --}}
                    <div class="absolute top-2 right-2">
                        <span class="px-2 py-0.5 bg-white/90 backdrop-blur-sm text-emerald-700 text-xs font-bold rounded-full border border-emerald-200">
                            {{ $book->stock }} stok
                        </span>
                    </div>
                </div>
                {{-- Info --}}
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2 mb-1 group-hover:text-purple-600 transition-colors">
                        {{ $book->title }}
                    </h3>
                    <p class="text-xs text-gray-400 truncate mb-3">{{ $book->author }}</p>
                    @if($book->category)
                    <span class="inline-block px-2 py-0.5 bg-purple-50 text-purple-600 rounded-full text-xs font-medium border border-purple-100">
                        {{ $book->category->name }}
                    </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="/login"
               class="inline-flex items-center gap-2 px-8 py-4 g-bg text-white font-bold rounded-2xl shadow-lg shadow-purple-300/30 hover:opacity-90 transition-opacity">
                Lihat Semua Koleksi →
            </a>
        </div>

        @else
        <div class="text-center py-20 text-gray-400">
            <div class="text-6xl mb-4">📭</div>
            <p class="font-medium">Belum ada buku tersedia saat ini.</p>
        </div>
        @endif
    </div>
</section>

{{-- ===========================
     CARA PEMINJAMAN
     =========================== --}}
<section id="cara" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-5">
                🔄 Cara Kerja
            </div>
            <h2 class="text-4xl md:text-5xl font-black mb-4">
                Cara <span class="g-text">Peminjaman</span>
            </h2>
            <p class="text-gray-500 max-w-xl mx-auto">4 langkah mudah untuk meminjam buku</p>
        </div>

        <div class="grid md:grid-cols-4 gap-6">
            @foreach([
                ['icon'=>'📝','title'=>'Daftar Akun','desc'=>'Buat akun gratis dan masuk ke ReadSpace'],
                ['icon'=>'🔍','title'=>'Cari Buku','desc'=>'Temukan buku yang ingin dipinjam'],
                ['icon'=>'📚','title'=>'Ajukan Pinjam','desc'=>'Klik Pinjam Sekarang di halaman buku'],
                ['icon'=>'✅','title'=>'Dikonfirmasi','desc'=>'Tunggu konfirmasi dari petugas perpustakaan'],
            ] as $i => $step)
            <div class="relative flex flex-col items-center text-center p-8 bg-gradient-to-b from-gray-50 to-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="w-16 h-16 g-bg rounded-2xl flex items-center justify-center text-3xl mb-4 shadow-lg shadow-purple-300/30">
                    {{ $step['icon'] }}
                </div>
                <div class="w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm mb-4">
                    {{ $i + 1 }}
                </div>
                <h4 class="font-bold text-lg mb-2 text-gray-800">{{ $step['title'] }}</h4>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                @if($i < 3)
                <div class="hidden md:block absolute top-14 -right-3 z-10">
                    <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===========================
     FEATURES
     =========================== --}}
<section class="py-24 bg-gradient-to-br from-purple-50/60 to-blue-50/60">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-5">
                💡 Fitur Unggulan
            </div>
            <h2 class="text-4xl md:text-5xl font-black mb-4">
                Kenapa <span class="g-text">ReadSpace?</span>
            </h2>
            <p class="text-gray-500 max-w-xl mx-auto">Semua yang kamu butuhkan untuk pengalaman perpustakaan yang modern</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon'=>'⚡','title'=>'Akses Cepat','desc'=>'Pinjam buku kapan saja hanya dengan beberapa klik dari browser.','color'=>'from-purple-100 to-purple-50','icon_bg'=>'bg-purple-500'],
                ['icon'=>'📋','title'=>'Sistem Persetujuan','desc'=>'Setiap permintaan diverifikasi petugas untuk memastikan ketersediaan.','color'=>'from-blue-100 to-blue-50','icon_bg'=>'bg-blue-500'],
                ['icon'=>'📊','title'=>'Pantau Riwayat','desc'=>'Lacak peminjaman aktif, riwayat, dan batas pengembalian secara real-time.','color'=>'from-emerald-100 to-emerald-50','icon_bg'=>'bg-emerald-500'],
                ['icon'=>'⭐','title'=>'Ulasan Buku','desc'=>'Beri rating dan komentar untuk membantu anggota lain memilih buku.','color'=>'from-amber-100 to-amber-50','icon_bg'=>'bg-amber-500'],
            ] as $f)
            <div class="group p-7 bg-gradient-to-b {{ $f['color'] }} rounded-3xl border border-white shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center">
                <div class="w-14 h-14 {{ $f['icon_bg'] }} rounded-2xl flex items-center justify-center text-2xl mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform">
                    {{ $f['icon'] }}
                </div>
                <h4 class="font-bold text-gray-800 mb-2 text-lg">{{ $f['title'] }}</h4>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===========================
     TENTANG
     =========================== --}}
<section id="tentang" class="py-24 g-bg text-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 rounded-full text-sm font-semibold mb-8 backdrop-blur-sm">
            ℹ️ Tentang Kami
        </div>
        <h2 class="text-4xl md:text-5xl font-black mb-6">Tentang ReadSpace</h2>
        <p class="text-lg leading-relaxed opacity-80 mb-14 max-w-2xl mx-auto">
            ReadSpace adalah sistem perpustakaan digital yang mempermudah pengelolaan koleksi buku,
            proses peminjaman, dan pengembalian secara online. Dibangun untuk perpustakaan modern
            dengan antarmuka yang intuitif dan alur persetujuan yang terstruktur.
        </p>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach([
                ['icon'=>'👥','title'=>'Multi Role','desc'=>'Admin, Petugas & Anggota'],
                ['icon'=>'💻','title'=>'Web Based','desc'=>'Akses dari browser manapun'],
                ['icon'=>'📱','title'=>'Responsif','desc'=>'Tampil sempurna di semua perangkat'],
            ] as $f)
            <div class="p-6 bg-white/10 rounded-2xl backdrop-blur-sm hover:bg-white/20 transition-colors border border-white/20">
                <div class="text-4xl mb-3">{{ $f['icon'] }}</div>
                <h4 class="font-bold text-lg mb-1">{{ $f['title'] }}</h4>
                <p class="opacity-70 text-sm">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===========================
     CTA
     =========================== --}}
<section class="py-24 bg-white text-center">
    <div class="max-w-2xl mx-auto px-6">
        <h2 class="text-4xl md:text-5xl font-black mb-4">
            Siap Mulai <span class="g-text">Membaca?</span>
        </h2>
        <p class="text-gray-500 mb-10 text-lg">
            Daftar gratis dan mulai nikmati kemudahan peminjaman buku digital.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="/register"
               class="px-10 py-4 g-bg text-white font-bold rounded-2xl shadow-xl shadow-purple-400/30 hover:opacity-90 transition text-sm">
                Daftar Gratis Sekarang →
            </a>
            <a href="/login"
               class="px-10 py-4 border-2 border-purple-200 text-purple-700 font-bold rounded-2xl hover:bg-purple-50 transition text-sm">
                Sudah Punya Akun
            </a>
        </div>
    </div>
</section>

{{-- ===========================
     FOOTER
     =========================== --}}
<footer class="bg-gray-950">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Main footer grid --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 py-16 border-b border-gray-800">

            {{-- Brand col (spans 2 on lg) --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-10 h-10 g-bg rounded-xl flex items-center justify-center text-white text-lg shadow-lg shadow-purple-900/40">📚</div>
                    <span class="text-xl font-extrabold text-white">ReadSpace</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-xs mb-6">
                    Sistem perpustakaan digital yang mempermudah akses, peminjaman, dan pengelolaan koleksi buku secara online.
                </p>
                {{-- Mini nav pills --}}
                <div class="flex flex-wrap gap-2">
                    @foreach(['#beranda'=>'Beranda','#koleksi'=>'Koleksi','#cara'=>'Cara Pinjam','#tentang'=>'Tentang'] as $href=>$label)
                    <a href="{{ $href }}" class="px-3 py-1.5 text-xs text-gray-400 border border-gray-700 rounded-lg hover:border-purple-500 hover:text-purple-400 transition-colors">
                        {{ $label }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Layanan --}}
            <div>
                <h5 class="text-white font-semibold mb-5 text-sm uppercase tracking-wider">Layanan</h5>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-center gap-2"><span class="text-purple-500">→</span> <a href="#koleksi" class="hover:text-purple-400 transition-colors">Katalog Buku</a></li>
                    <li class="flex items-center gap-2"><span class="text-purple-500">→</span> <a href="#cara" class="hover:text-purple-400 transition-colors">Peminjaman Online</a></li>
                    <li class="flex items-center gap-2"><span class="text-purple-500">→</span> <span class="text-gray-500">Riwayat Pinjam</span></li>
                    <li class="flex items-center gap-2"><span class="text-purple-500">→</span> <span class="text-gray-500">Ulasan Buku</span></li>
                </ul>
            </div>

            {{-- Akun --}}
            <div>
                <h5 class="text-white font-semibold mb-5 text-sm uppercase tracking-wider">Akun</h5>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex items-center gap-2"><span class="text-blue-500">→</span> <a href="/login" class="hover:text-blue-400 transition-colors">Masuk</a></li>
                    <li class="flex items-center gap-2"><span class="text-blue-500">→</span> <a href="/register" class="hover:text-blue-400 transition-colors">Daftar Gratis</a></li>
                    @auth
                    <li class="flex items-center gap-2"><span class="text-blue-500">→</span> <a href="{{ route('user.dashboard') }}" class="hover:text-blue-400 transition-colors">Dashboard</a></li>
                    @endauth
                </ul>
                {{-- CTA mini --}}
                <a href="/register" class="inline-flex items-center gap-2 mt-6 px-4 py-2.5 g-bg text-white text-xs font-bold rounded-xl shadow-lg shadow-purple-900/40 hover:opacity-90 transition-opacity">
                    Daftar Sekarang →
                </a>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="py-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-600">© {{ date('Y') }} ReadSpace. Sistem Manajemen Perpustakaan Digital.</p>
            <div class="flex items-center gap-1.5 text-xs text-gray-700">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Semua sistem berjalan normal
            </div>
        </div>
    </div>
</footer>

<script>
// Navbar scroll effect
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
});

// Mobile menu toggle
document.getElementById('mobile-btn').addEventListener('click', () => {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});

// Smooth scroll for all anchor links
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            document.getElementById('mobile-menu').classList.add('hidden');
        }
    });
});
</script>

</body>
</html>