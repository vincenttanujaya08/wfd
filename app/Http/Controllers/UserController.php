<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Mengembalikan semua user (kecuali admin & banned) – urut asli.
     */
    public function indexAll()
    {
        $users = User::whereHas('role', fn($q) =>
                    $q->whereNotIn('name',['admin','banned'])
                )
                ->get(['id','name','profile_image','role_id','description']);

        return response()->json($users,200);
    }

    /**
     * Mengembalikan semua user (kecuali admin & banned) – di‐shuffle.
     */
    public function indexAllShuffled()
    {
        $users = User::whereHas('role', fn($q) =>
                    $q->whereNotIn('name',['admin','banned'])
                )
                ->get(['id','name','profile_image','role_id','description'])
                ->toArray();

        shuffle($users);
        return response()->json($users,200);
    }

    /**
     * Cari user (kecuali admin & banned) dengan LIKE.
     * GET /users/search?query=john
     */
    public function search(Request $request)
    {
        $term = trim($request->input('query',''));
        if ($term === '') {
            return response()->json([],200);
        }

        $users = User::whereHas('role', fn($q) =>
                        $q->whereNotIn('name',['admin','banned'])
                    )
                    ->where('name','like',"%{$term}%")
                    ->limit(10)
                    ->get(['id','name','profile_image','role_id','description']);

        return response()->json($users,200);
    }
}
