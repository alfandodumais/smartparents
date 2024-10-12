<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil semua pengguna terdaftar (user dan admin)
        $users = User::latest()->paginate(10); // Menghapus filter role agar semua pengguna ditampilkan
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|in:user,admin', // Validasi peran yang diizinkan
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully.');
    }
}
