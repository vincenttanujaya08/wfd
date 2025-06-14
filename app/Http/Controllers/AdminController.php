<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Method untuk dashboard admin
    public function dashboard()
    {
        // Kamu bisa ambil data statistik di sini, misal jumlah user, post, dsb
        // Contoh simpel:
        return view('admin.dashboard');
    }
}
