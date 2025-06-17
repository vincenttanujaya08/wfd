<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Tampilkan form pembuatan user baru
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Simpan user baru ke database
     */
    public function store(Request $r)
    {
        $r->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed|min:6',
            'role_id'               => 'required|in:1,2,3',
        ]);

        User::create([
            'name'     => $r->name,
            'email'    => $r->email,
            'password' => Hash::make($r->password),
            'role_id'  => $r->role_id,
        ]);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'User/Admin berhasil ditambahkan');
    }

    /**
     * Tampilkan form edit user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update data user
     */
    public function update(Request $req, User $user)
    {
        $req->validate([
            'name'    => 'required|string|max:255',
            'role_id' => 'required|in:1,2,3',
        ]);

        $user->update($req->only('name', 'role_id'));

        return redirect()->route('admin.dashboard')
                         ->with('success', 'User berhasil diperbarui');
    }
}
