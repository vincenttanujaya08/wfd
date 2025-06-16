<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;

class AdminReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['reporter','reportedUser','handledByAdmin'])
                         ->orderBy('status','asc')
                         ->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        $report->load(['images','reporter','reportedUser']);
        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $action = $request->input('action');
        switch ($action) {
            case 'cancel':
                $report->update(['status'=>'cancelled']);
                break;
            case 'warning':
                $report->update(['status'=>'handled']);
                $report->reportedUser->warnings()->create([
                    'admin_id'  => Auth::id(),
                    'message'   => $request->input('message','Warning issued'),
                    'report_id' => $report->id,
                ]);
                break;
            case 'ban':
                $report->update(['status'=>'handled']);
                $report->reportedUser->bans()->create([
                    'admin_id'     => Auth::id(),
                    'banned_at'    => now(),
                    'banned_until' => $request->input('banned_until'),
                    'reason'       => $request->input('reason','Banned by admin'),
                    'is_active'    => 1,
                    'report_id'    => $report->id,
                ]);
                break;
            default:
                return back()->withErrors(['action'=>'Invalid action']);
        }
        return redirect()->route('admin.reports.index')
                         ->with('success','Report '.$action.' berhasil.');
    }
}
