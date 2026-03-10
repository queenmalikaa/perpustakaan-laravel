@extends('layouts.admin')

@section('title', 'Tambah Peminjaman | ReadSpace')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- HEADER -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('peminjaman') }}" class="p-2 hover:bg-white rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">
                    Catat Peminjaman
                </h1>
            </div>
            <p class="text-gray-600 ml-12">Buat catatan peminjaman buku baru untuk anggota</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- FORM CARD -->
        <form action="{{ route('peminjaman.store') }}" method="POST" class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            @csrf
            
            <div class="p-8 space-y-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Peminjam -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Peminjam <span class="text-red-500">*</span>
                        </label>
                        <select name="user_id" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white">
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->nama_lengkap }} ({{ $user->username }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buku -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Buku yang Dipinjam <span class="text-red-500">*</span>
                        </label>
                        <select name="book_id" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }} (Stok Tersedia: {{ $book->stock }})
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Hanya buku dengan stok > 0 yang ditampilkan
                        </p>
                        @error('book_id')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Tanggal Pinjam <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200">
                        @error('tanggal_pinjam')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Kembali -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Batas Tanggal Kembali <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200">
                        @error('tanggal_kembali')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <!-- Buttons -->
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('peminjaman') }}"
                    class="px-6 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition-all duration-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all duration-200">
                    Simpan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
