<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Staff & Petugas
        $users = \App\Models\User::whereIn('role', ['admin', 'petugas'])->latest()->get();
        return view('admin.account.index', compact('users'));
    }

    public function pembaca()
    {
        // Pembaca (User) with loan + collection counts
        $users = \App\Models\User::where('role', 'user')
            ->withCount(['peminjaman', 'koleksi'])
            ->latest()
            ->get();
        return view('admin.account.pembaca', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.account.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petugas,user',
            'alamat' => 'nullable|string',
        ]);

        \App\Models\User::create([
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $request->role,
            'alamat' => $request->alamat,
        ]);

        $redirectRoute = $request->role === 'user' ? 'account.pembaca' : 'account';
        return redirect()->route($redirectRoute)->with('success', 'Akun berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.account.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,petugas,user',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'role' => $request->role,
            'alamat' => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($data);

        $redirectRoute = $user->role === 'user' ? 'account.pembaca' : 'account';
        return redirect()->route($redirectRoute)->with('success', 'Akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $role = $user->role;
        $user->delete();

        $redirectRoute = $role === 'user' ? 'account.pembaca' : 'account';
        return redirect()->route($redirectRoute)->with('success', 'Akun berhasil dihapus.');
    }
}
