<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Ban;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // hitung card‐values
        $totalUsers         = User::count();
        $activeReports      = Report::where('status','pending')->count();
        $pendingSuspensions = Ban::where('is_active', true)->count();

        // ambil search keyword (atau kosong)
        $q = $request->input('search','');

        // query users dengan search jika ada
        $userQuery = User::with(['role','reportsReceived','warnings','bans']);
        if ($q !== '') {
            $userQuery->where(function($w) use($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('email','like', "%{$q}%");
            });
        }
        // paginate & pertahankan param search di link
        $users = $userQuery->paginate(10)
                           ->appends(['search'=>$q]);

        // ambil reports untuk tabel
        $reports = Report::with(['reporter','reportedUser','handledByAdmin'])
                         ->orderBy('status','asc')
                         ->paginate(10);

        // kirim semua ke view
        return view('admin.dashboard', compact(
            'totalUsers',
            'activeReports',
            'pendingSuspensions',
            'users',
            'reports',
            'q'             // <-- penting agar {{ $q }} tidak undefined
        ));
    }
}
