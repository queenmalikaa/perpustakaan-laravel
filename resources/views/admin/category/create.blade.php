@extends('layouts.admin')

@section('title', 'Tambah Kategori | Admin ReadSpace')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    {{-- Changed from max-w-2xl to max-w-4xl to match books page --}}
    <div class="max-w-4xl mx-auto">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a 
                    href="{{ route('category') }}" 
                    class="p-2 hover:bg-white rounded-lg transition-colors duration-200"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">
                    Tambah Kategori Baru
                </h1>
            </div>
            <p class="text-gray-600 ml-12">Buat kategori baru untuk mengelompokkan koleksi buku</p>
        </div>

        {{-- Main Form Card --}}
        <form 
            action="{{ route('category.store') }}" 
            method="POST"
            class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
        >
            @csrf

            <div class="p-8 space-y-6">
                
                {{-- Icon Header --}}
                <div class="flex justify-center mb-6">
                    <div class="p-6 bg-gradient-to-br from-purple-100 to-blue-100 rounded-2xl">
                        <svg class="w-16 h-16 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>

                {{-- Nama Kategori --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Novel, Teknologi, Sejarah, Pendidikan"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 @error('name') border-red-300 @enderror"
                        required
                    >
                    @error('name')
                        <div class="flex items-center gap-1 mt-2 text-red-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm">{{ $message }}</p>
                        </div>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">Nama kategori harus unik dan deskriptif</p>
                </div>

                {{-- Info Box --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 mb-1">Tips Membuat Kategori</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Gunakan nama yang spesifik dan mudah dipahami</li>
                                <li>• Hindari membuat terlalu banyak kategori serupa</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Action Buttons - Footer --}}
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>Field dengan <span class="text-red-500">*</span> wajib diisi</span>
                </div>
                
                <div class="flex gap-3 w-full sm:w-auto">
                    <a 
                        href="{{ route('category') }}"
                        class="flex-1 sm:flex-none px-6 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-medium hover:bg-gray-100 transition-all duration-200 text-center"
                    >
                        Batal
                    </a>
                    <button 
                        type="submit"
                        class="flex-1 sm:flex-none px-8 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold hover:from-purple-700 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Kategori
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>

{{-- JavaScript for form validation --}}
<script>
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const nameInput = document.querySelector('input[name="name"]');
        const name = nameInput.value.trim();
        
        if (!name) {
            e.preventDefault();
            nameInput.focus();
            nameInput.classList.add('border-red-500');
            alert('Nama kategori wajib diisi!');
        }
    });
</script>

@endsection