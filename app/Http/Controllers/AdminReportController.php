<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Models\User;

class AdminReportController extends Controller
{
    /** Paginated queue */
    public function index()
    {
        $reports = Report::with(['reporter', 'reportedUser', 'handledByAdmin'])
            ->orderBy('status', 'asc')
            ->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }


    /** Detail + image slider */
    public function show(Report $report)
    {
        $report->load(['images', 'reporter', 'reportedUser']);
        return view('admin.reports.show', compact('report'));
    }

    /** Handle action: cancel/delete, warning, or ban */
    public function handle(Request $req, Report $report)
    {
        $action = $req->input('action');
        switch ($action) {
            case 'cancel':
                $report->delete();
                return redirect()->route('admin.reports.index')
                    ->with('success', 'Report deleted.');
            case 'warning':
                $report->update([
                    'status' => 'handled',
                    'handled_by_admin_id' => Auth::id(),
                    'handled_at' => now(),
                ]);

                // attach a warning record...
                $report->reportedUser->warnings()->create([
                    'admin_id' => Auth::id(),
                    'message' => $req->input('message', 'This is an official warning: your recent activity violates our Community Guidelines. Please review the rules and adjust your behavior to avoid further action.'),
                    'report_id' => $report->id,
                ]);
                break;
            case 'ban':
                $report->update([
                    'status' => 'handled',
                    'handled_by_admin_id' => Auth::id(),
                    'handled_at' => now(),
                ]);


                $user = $report->reportedUser;
                // only downgrade if they’re not already an admin
                if ($user->role_id !== 1) {
                    $user->update(['role_id' => 3]);
                }
                break;

            default:
                return back()->withErrors('Unknown action.');
        }

        return redirect()->route('admin.reports.index')
            ->with('success', ucfirst($action) . ' successful.');
    }
}
