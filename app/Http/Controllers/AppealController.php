<?php
// app/Http/Controllers/AppealController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appeal;
use App\Models\Ban;
use Illuminate\Support\Carbon;

class AppealController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        // Cari ban aktif untuk user ini
        $ban = Ban::where('user_id', $user->id)
            ->where('is_active', 1)
            ->where('banned_until', '>=', Carbon::now())
            ->first();

        if (! $ban) {
            // Kalau tidak diban, redirect saja
            return redirect()->route('home')
                ->with('info', 'Anda tidak sedang diblokir.');
        }

        // Jika ada, tampilkan form appeal beserta data $ban
        return view('appeals.create', compact('ban'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $data = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        // Ulangi query yang sama untuk memastikan user masih diban
        $ban = Ban::where('user_id', $user->id)
            ->where('is_active', 1)
            ->where('banned_until', '>=', Carbon::now())
            ->first();

        if (! $ban) {
            return redirect()->route('home')
                ->with('info', 'Anda tidak sedang diblokir.');
        }

        // Simpan appeal
        Appeal::create([
            'ban_id'  => $ban->id,
            'user_id' => $user->id,
            'message' => $data['message'],
            'status'  => 'pending',
        ]);

        return redirect()->route('appeal.create')
            ->with('success', 'Banding Anda berhasil dikirim. Silakan tunggu konfirmasi.');
    }
}
