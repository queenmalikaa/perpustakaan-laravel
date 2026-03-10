@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a 
                    href="{{ route('books') }}" 
                    class="p-2 hover:bg-white rounded-lg transition-colors duration-200"
                >
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">
                    Tambah Buku Baru
                </h1>
            </div>
            <p class="text-gray-600 ml-12">Lengkapi informasi buku yang akan ditambahkan ke perpustakaan</p>
        </div>

        <form 
            action="{{ route('books.store') }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden"
        >
            @csrf

            <div class="p-8 space-y-8">
                
                {{-- Informasi Dasar Section --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Informasi Dasar
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                         {{-- Kode Buku --}}
                         <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Buku <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="code"
                                value="{{ old('code', $code) }}"
                                placeholder="Masukkan kode buku"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                            >
                        </div>

                        {{-- Judul Buku --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Judul Buku <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Masukkan judul buku"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 @error('title') border-red-300 @enderror"
                            >
                            @error('title')
                                <div class="flex items-center gap-1 mt-2 text-red-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <p class="text-sm">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        {{-- Penulis --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Penulis <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="author"
                                value="{{ old('author') }}"
                                placeholder="Nama penulis"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                            >
                        </div>

                        {{-- Penerbit --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Penerbit <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="publisher"
                                value="{{ old('publisher') }}"
                                placeholder="Nama penerbit"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                            >
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="category_id"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 appearance-none bg-white"
                                style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 24 24%27 fill=%27none%27 stroke=%27currentColor%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27%3e%3cpolyline points=%276 9 12 15 18 9%27%3e%3c/polyline%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25em;"
                            >
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option 
                                        value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tahun Terbit --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Tahun Terbit <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="year"
                                value="{{ old('year') }}"
                                placeholder="2024"
                                min="1900"
                                max="{{ date('Y') + 1 }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                            >
                        </div>

                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-200"></div>

                {{-- Stok & Cover Section --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Stok & Cover
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Stok --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Jumlah Stok <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    name="stock"
                                    value="{{ old('stock') }}"
                                    placeholder="0"
                                    min="0"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200"
                                >
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">
                                    Buku
                                </div>
                            </div>
                        </div>

                        {{-- Cover Upload --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Cover Buku
                            </label>
                            <div class="relative">
                                <input 
                                    type="file" 
                                    name="cover"
                                    accept="image/*"
                                    id="cover-upload"
                                    class="hidden"
                                    onchange="previewCover(event)"
                                >
                                <label 
                                    for="cover-upload"
                                    class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl border-2 border-dashed border-gray-300 hover:border-purple-500 hover:bg-purple-50 transition-all duration-200 cursor-pointer"
                                >
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <span class="text-sm text-gray-600" id="file-name">Pilih file cover</span>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, WEBP (Max. 2MB)</p>
                            
                            {{-- Cover Preview --}}
                            <div id="cover-preview" class="hidden mt-4">
                                <img src="" alt="Preview" class="w-32 h-40 object-cover rounded-lg shadow-md border-2 border-gray-200">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-200"></div>

                {{-- Deskripsi Section --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        Deskripsi
                    </h2>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi Buku
                        </label>
                        <textarea 
                            rows="5" 
                            name="description"
                            placeholder="Tulis sinopsis atau deskripsi singkat tentang buku ini..."
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 resize-none"
                        >{{ old('description') }}</textarea>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-xs text-gray-500">Minimal 50 karakter</p>
                            <p class="text-xs text-gray-400" id="char-count">0 karakter</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Action Buttons - Sticky Footer --}}
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span>Field dengan <span class="text-red-500">*</span> wajib diisi</span>
                </div>
                
                <div class="flex gap-3 w-full sm:w-auto">
                    <a 
                        href="{{ route('books') }}"
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
                        Simpan Buku
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>

{{-- JavaScript for interactions --}}
<script>
    // Cover preview
    function previewCover(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('cover-preview');
        const fileName = document.getElementById('file-name');
        
        if (file) {
            fileName.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Character counter
    const textarea = document.querySelector('textarea[name="description"]');
    const charCount = document.getElementById('char-count');
    
    textarea.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = count + ' karakter';
        
        if (count < 50) {
            charCount.classList.add('text-red-500');
            charCount.classList.remove('text-gray-400');
        } else {
            charCount.classList.remove('text-red-500');
            charCount.classList.add('text-green-600');
        }
    });

    // Form validation highlight
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('border-red-500');
                isValid = false;
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi');
        }
    });
</script>

@endsection