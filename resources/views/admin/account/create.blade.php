@extends('layouts.admin')

@section('title', 'Tambah Akun | Admin ReadSpace')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a 
                    href="{{ request('role') == 'user' ? route('account.pembaca') : route('account') }}" 
                    class="p-2 hover:bg-white rounded-lg transition-colors duration-200"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">
                    Tambah Akun Baru
                </h1>
            </div>
            <p class="text-gray-600 ml-12">Tambahkan akun staff, admin, atau pembaca baru</p>
        </div>

        <form 
            action="{{ route('account.store') }}" 
            method="POST" 
            class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
        >
            @csrf

            <div class="p-8 space-y-8">
                
                {{-- Informasi Dasar Section --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Akun
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Nama Lengkap --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama_lengkap"
                                value="{{ old('nama_lengkap') }}"
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                                required
                            >
                        </div>

                        {{-- Username --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Username unik"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                                required
                            >
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="contoh@email.com"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                                required
                            >
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Role / Peran <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="role"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white"
                                required
                            >
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" {{ (old('role') == 'admin' || request('role') == 'admin') ? 'selected' : '' }}>Admin</option>
                                <option value="petugas" {{ (old('role') == 'petugas' || request('role') == 'petugas') ? 'selected' : '' }}>Petugas</option>
                                <option value="user" {{ (old('role') == 'user' || request('role') == 'user') ? 'selected' : '' }}>Pembaca (User)</option>
                            </select>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="password" 
                                name="password"
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                                required
                            >
                        </div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat
                            </label>
                            <textarea 
                                name="alamat"
                                rows="3"
                                placeholder="Alamat lengkap (opsional)"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 resize-none"
                            >{{ old('alamat') }}</textarea>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a 
                    href="{{ request('role') == 'user' ? route('account.pembaca') : route('account') }}"
                    class="px-6 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition-all duration-200"
                >
                    Batal
                </a>
                <button 
                    type="submit"
                    class="px-8 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold hover:from-purple-700 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all duration-200"
                >
                    Simpan Akun
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
