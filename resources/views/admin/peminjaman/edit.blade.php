@extends('layouts.admin')

@section('title', 'Edit Peminjaman | ReadSpace')

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
                    Edit Peminjaman
                </h1>
            </div>
            <p class="text-gray-600 ml-12">Perbarui status atau tanggal peminjaman</p>
        </div>

        <!-- FORM CARD -->
        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="p-8 space-y-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Info Peminjam (Disabled) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Peminjam</label>
                        <div class="w-full px-4 py-3 border-2 border-gray-100 rounded-xl bg-gray-50 text-gray-500 font-medium">
                            {{ $peminjaman->user->nama_lengkap }}
                        </div>
                    </div>

                    <!-- Info Buku (Disabled) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Buku</label>
                        <div class="w-full px-4 py-3 border-2 border-gray-100 rounded-xl bg-gray-50 text-gray-500 font-medium">
                            {{ $peminjaman->book->title }}
                        </div>
                    </div>

                    <!-- Tanggal Pinjam (Disabled) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pinjam</label>
                        <div class="w-full px-4 py-3 border-2 border-gray-100 rounded-xl bg-gray-50 text-gray-500 font-medium">
                            {{ $peminjaman->tanggal_pinjam->format('d F Y') }}
                        </div>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Batas Tanggal Kembali <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali->format('Y-m-d')) }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200">
                        @error('tanggal_kembali')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Peminjaman <span class="text-red-500">*</span>
                        </label>
                        <select name="status" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 bg-white">
                            <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam (Sedang berlangsung)</option>
                            <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan (Selesai)</option>
                            <option value="terlambat" {{ $peminjaman->status == 'terlambat' ? 'selected' : '' }}>Terlambat (Melewati batas)</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-2">
                            <span class="font-semibold text-purple-600">Catatan:</span> Mengubah status menjadi "Dikembalikan" akan otomatis menambah stok buku.
                        </p>
                        @error('status')
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
