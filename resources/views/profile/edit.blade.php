@php
    $layout = match(Auth::user()->role) {
        'admin'   => 'layouts.admin',
        'petugas' => 'layouts.petugas',
        default   => 'layouts.user',
    };
@endphp

@extends($layout)

@section('title', 'Edit Profil | ReadSpace')
@section('header_title', 'Edit Profil')

@section('content')
<div class="p-8 md:p-10 max-w-7xl mx-auto">

    <!-- HEADER STRIP -->
    <div class="mb-8">
        <div class="h-1 w-20 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full mb-4"></div>
        <h1 class="text-3xl font-bold text-gray-800">Profil Saya</h1>
        <p class="text-gray-400 mt-1">Kelola informasi akun dan keamanan kamu.</p>
    </div>

    <!-- ====== UPDATE PROFILE INFORMATION ====== -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
        <div class="flex items-center gap-4 mb-6">
            <!-- Avatar circle -->
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500
                        flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                {{ strtoupper(substr(Auth::user()->username ?? 'U', 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ Auth::user()->username }}</h2>
                <p class="text-sm text-gray-400">{{ Auth::user()->email }}</p>
                <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 capitalize">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </div>

        <hr class="border-gray-100 mb-6">

        <h3 class="text-base font-bold text-gray-700 mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Informasi Akun
        </h3>

        @if(session('status') === 'profile-updated')
        <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl">
            ✅ <span class="font-medium">Profil berhasil diperbarui!</span>
        </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
            @csrf
            @method('patch')

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-600 mb-1.5">Username</label>
                <input type="text" id="username" name="username"
                       value="{{ old('username', $user->username) }}"
                       required autocomplete="username"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800
                              focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                              transition-all @error('username') border-red-400 bg-red-50 @enderror">
                @error('username')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-600 mb-1.5">Alamat Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       required autocomplete="email"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800
                              focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                              transition-all @error('email') border-red-400 bg-red-50 @enderror">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold
                               rounded-xl transition-all shadow-sm shadow-emerald-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- ====== UPDATE PASSWORD ====== -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-6">
        <h3 class="text-base font-bold text-gray-700 mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Ubah Password
        </h3>

        @if(session('status') === 'password-updated')
        <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-xl">
            ✅ <span class="font-medium">Password berhasil diperbarui!</span>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-600 mb-1.5">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password"
                       autocomplete="current-password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800
                              focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent
                              transition-all @error('current_password', 'updatePassword') border-red-400 bg-red-50 @enderror">
                @error('current_password', 'updatePassword')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-600 mb-1.5">Password Baru</label>
                <input type="password" id="password" name="password"
                       autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800
                              focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent
                              transition-all @error('password', 'updatePassword') border-red-400 bg-red-50 @enderror">
                @error('password', 'updatePassword')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-600 mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       autocomplete="new-password"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-800
                              focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent
                              transition-all @error('password_confirmation', 'updatePassword') border-red-400 bg-red-50 @enderror">
                @error('password_confirmation', 'updatePassword')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold
                               rounded-xl transition-all shadow-sm shadow-blue-200">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- ====== DELETE ACCOUNT ====== -->
    <div class="bg-white rounded-3xl shadow-sm border border-red-100 p-8">
        <h3 class="text-base font-bold text-red-600 mb-2 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus Akun
        </h3>
        <p class="text-sm text-gray-500 mb-5">
            Setelah akun dihapus, semua data akan hilang permanen. Pastikan kamu sudah yakin sebelum melanjutkan.
        </p>

        <button type="button" onclick="document.getElementById('delete-modal').classList.remove('hidden')"
                class="px-6 py-2.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 border border-red-200
                       hover:border-red-500 font-semibold rounded-xl transition-all text-sm">
            Hapus Akun Saya
        </button>
    </div>

</div>

<!-- DELETE MODAL -->
<div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-md mx-4">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Yakin hapus akun?</h3>
            <p class="text-sm text-gray-500">Masukkan password kamu untuk konfirmasi. Tindakan ini tidak bisa dibatalkan.</p>
        </div>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-5">
                <label for="del_password" class="block text-sm font-semibold text-gray-600 mb-1.5">Password</label>
                <input type="password" id="del_password" name="password"
                       placeholder="Masukkan password kamu"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-400">
                @error('password', 'userDeletion')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('delete-modal').classList.add('hidden')"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-all">
                    Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
