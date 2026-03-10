@extends('layouts.admin')

@section('title', 'Manajemen Staff | Admin ReadSpace')
@section('header_title', 'Manajemen Staff')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
        
        <!-- HEADER -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    👥 Manajemen Staff
                </h1>
                <p class="text-gray-600">
                    Kelola akun petugas dan admin perpustakaan
                </p>
            </div>

            <a
                href="{{ route('account.create', ['role' => 'petugas']) }}"
                class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl hover:from-purple-700 hover:to-blue-700 transition-all duration-200 font-semibold"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Tambah Staff
            </a>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-purple-50 to-blue-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-purple-50/50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-900">{{ $user->nama_lengkap }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->username }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($user->role == 'admin')
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        Petugas
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('account.edit', $user->id) }}" class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-150" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('account.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-150" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data staff.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection