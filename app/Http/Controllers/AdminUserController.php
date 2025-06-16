<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('search');
        $query = User::with(['role','reportsReceived','warnings','bans']);
        if($q) {
            $query->where('name','like',"%{$q}%")
                  ->orWhere('email','like',"%{$q}%");
        }
        $users = $query->paginate(10);
        return view('admin.users.index', compact('users','q'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed',
            'role_id'               => 'required|exists:roles,id'
        ]);
        User::create([
            'name'      => $r->name,
            'email'     => $r->email,
            'password'  => Hash::make($r->password),
            'role_id'   => $r->role_id,
        ]);
        return redirect()->route('admin.users.index')
                         ->with('success','User/Admin berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);
        $user->update($request->only('name','role_id'));
        return redirect()->route('admin.users.index')
                         ->with('success','User berhasil diperbarui');
    }
}
