@extends('layouts.admin')

@section('title', 'Manajemen Pembaca | Admin ReadSpace')
@section('header_title', 'Manajemen Pembaca')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-1">📖 Manajemen Pembaca</h1>
            <p class="text-gray-500">Daftar anggota perpustakaan yang terdaftar.</p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg flex items-center justify-between">
            <span>✅ {{ session('success') }}</span>
            <button onclick="this.parentElement.remove()">✕</button>
        </div>
        @endif

        <!-- TABLE CARD -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alamat</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $index => $user)
                        <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <!-- Avatar -->
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-400 to-blue-500
                                                flex items-center justify-center text-white text-sm font-bold shrink-0">
                                        {{ strtoupper(substr($user->nama_lengkap ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $user->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->username }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-gray-500 truncate max-w-xs">{{ $user->alamat ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Lihat Detail (popup) -->
                                    <button type="button"
                                            onclick="openDetail({{ json_encode([
                                                'nama'      => $user->nama_lengkap,
                                                'username'  => $user->username,
                                                'email'     => $user->email,
                                                'alamat'    => $user->alamat ?? '-',
                                                'bergabung' => $user->created_at->format('d M Y'),
                                                'pinjaman'  => $user->peminjaman_count,
                                                'koleksi'   => $user->koleksi_count,
                                            ]) }})"
                                            class="p-2 rounded-lg bg-purple-50 text-purple-600 hover:bg-purple-100 transition-colors" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>

                                    <!-- Hapus -->
                                    <form action="{{ route('account.destroy', $user->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus akun {{ $user->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="font-medium">Belum ada pembaca terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50 text-sm text-gray-400">
                Total: {{ $users->count() }} pembaca
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL DETAIL PEMBACA ===== -->
<div id="detail-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
     onclick="if(event.target===this) closeDetail()">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">

        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-8 py-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div id="modal-avatar"
                     class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white text-2xl font-bold">
                </div>
                <div>
                    <h2 id="modal-nama" class="text-xl font-bold text-white"></h2>
                    <p id="modal-username" class="text-purple-200 text-sm"></p>
                </div>
            </div>
            <button onclick="closeDetail()" class="text-white/70 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Stats Bar -->
        <div class="grid grid-cols-2 border-b border-gray-100">
            <div class="px-6 py-4 text-center border-r border-gray-100">
                <p id="modal-pinjaman" class="text-2xl font-bold text-purple-600"></p>
                <p class="text-xs text-gray-400 mt-0.5">Total Pinjaman</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p id="modal-koleksi" class="text-2xl font-bold text-blue-600"></p>
                <p class="text-xs text-gray-400 mt-0.5">Koleksi Pribadi</p>
            </div>
        </div>

        <!-- Info Fields -->
        <div class="px-8 py-6 space-y-4">
            <div class="flex items-start gap-4">
                <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Email</p>
                    <p id="modal-email" class="text-gray-800 font-medium text-sm"></p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Alamat</p>
                    <p id="modal-alamat" class="text-gray-800 font-medium text-sm"></p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Bergabung</p>
                    <p id="modal-bergabung" class="text-gray-800 font-medium text-sm"></p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-8 pb-6">
            <button onclick="closeDetail()"
                    class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
function openDetail(data) {
    document.getElementById('modal-nama').textContent      = data.nama;
    document.getElementById('modal-username').textContent  = '@' + data.username;
    document.getElementById('modal-avatar').textContent    = data.nama.charAt(0).toUpperCase();
    document.getElementById('modal-email').textContent     = data.email;
    document.getElementById('modal-alamat').textContent    = data.alamat;
    document.getElementById('modal-bergabung').textContent = data.bergabung;
    document.getElementById('modal-pinjaman').textContent  = data.pinjaman;
    document.getElementById('modal-koleksi').textContent   = data.koleksi;
    document.getElementById('detail-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeDetail() {
    document.getElementById('detail-modal').classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
@endsection
