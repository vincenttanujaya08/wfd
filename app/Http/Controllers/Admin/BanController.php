<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ban;
use App\Models\Report;

class BanController extends Controller
{
    public function index()
    {
        $bans = Ban::with(['user', 'admin', 'report'])
            ->paginate(10);
        return view('admin.bans.index', compact('bans'));
    }

    public function store(Request $r)
{
    $data = $r->validate([
        'user_id'      => 'required|exists:users,id',
        'reason'       => 'nullable|string|max:500',
        'banned_until' => 'nullable|date',
        'report_id'    => 'nullable|exists:reports,id',
    ]);

    $data['admin_id']  = auth()->id();
    $data['banned_at'] = now();
    $data['is_active'] = true;

    $ban = Ban::create($data);

    // mark the report handled
    if ($r->filled('report_id')) {
        Report::where('id', $r->input('report_id'))
              ->update([
                  'status'              => 'handled',
                  'handled_by_admin_id' => auth()->id(),
                  'handled_at'          => now(),
              ]);
    }

    return redirect()
        ->route('admin.bans.index')
        ->with('success','User telah di-ban.');
}



    public function update(Request $r, Ban $ban)
    {
        $ban->update([
            'is_active' => false,
            'banned_until' => now(),
        ]);
        return back()->with('success', 'User telah di-unban');
    }
}
