<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Models\Ban;

class AdminController extends Controller
{
    /** Tampilkan dashboard + user management + reports */
    public function dashboard(Request $request)
    {
        // 1) Statistik
        $totalUsers = User::count();
        $activeReports = Report::where('status', 'pending')->count();
        $pendingSuspensions = Ban::where('is_active', true)->count();

        // Baca filter
        $roleFilter = $request->input('filter_role');      // 1,2,3 atau empty
        $statusFilter = $request->input('filter_status');    // active|banned atau empty
        $minReports = $request->input('filter_min_reports');
        $maxReports = $request->input('filter_max_reports');
        $minWarnings = $request->input('filter_min_warnings');
        $maxWarnings = $request->input('filter_max_warnings');

        // 2) Ambil user & paginasi 10 per page (pencarian via ?search=…)
        $q = $request->input('search', '');
        $userQuery = User::with('role')
            ->withCount(['reportsReceived', 'warnings', 'bans']);
        if ($q !== '') {
            $userQuery->where(
                fn($w) =>
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
            );
        }
        // filter role
        if (in_array($roleFilter, ['1', '2', '3'])) {
            $userQuery->where('role_id', $roleFilter);
        }
        // filter status
        if ($statusFilter === 'active') {
            $userQuery->whereDoesntHave(
                'bans',
                fn($b) =>
                $b->where('is_active', true)
            )->where('role_id', '!=', 3);
        } elseif ($statusFilter === 'banned') {
            $userQuery->where(function ($q) {
                $q->where('role_id', 3)
                    ->orWhereHas(
                        'bans',
                        fn($b) =>
                        $b->where('is_active', true)
                    );
            });
        }

        // filter jumlah reports
        if (is_numeric($minReports)) {
            $userQuery->having('reports_received_count', '>=', $minReports);
        }
        if (is_numeric($maxReports)) {
            $userQuery->having('reports_received_count', '<=', $maxReports);
        }
        // filter warnings
        if (is_numeric($minWarnings)) {
            $userQuery->having('warnings_count', '>=', $minWarnings);
        }
        if (is_numeric($maxWarnings)) {
            $userQuery->having('warnings_count', '<=', $maxWarnings);
        }


        $users = $userQuery->paginate(5)->appends(['search' => $q]);

        // 3) Ambil reports queue
        $reports = Report::with(['reporter', 'reportedUser', 'handledByAdmin'])
            ->orderBy('status', 'asc')
            ->paginate(10);
        return view('admin.dashboard', compact(
            'totalUsers',
            'activeReports',
            'pendingSuspensions',
            'users',
            'reports',
            'q',
            'roleFilter',
            'statusFilter',
            'minReports',
            'maxReports',
            'minWarnings',
            'maxWarnings'
        ));
    }

    /** AJAX: cari user, dipanggil setiap input (tanpa enter) */
    public function searchUsers(Request $request)
    {
        $q = $request->input('q', '');
        $query = User::with('role')  // eager load role relationship
            ->withCount(['reportsReceived', 'warnings', 'bans']);

        if ($q !== '') {
            $query->where(
                fn($w) =>
                $w->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
            );
        }
        $users = $query->paginate(5);

        // Modify the role data before returning the users
        $users->getCollection()->transform(function ($user) {
            // Check role_id and convert to appropriate role name
            $roleName = 'User';  // Default value
            if ($user->role) {
                if ($user->role->id == 1) {
                    $roleName = 'Admin';
                } elseif ($user->role->id == 2) {
                    $roleName = 'User';
                } elseif ($user->role->id == 3) {
                    $roleName = 'Banned';
                }
            }
            $user->role_name = $roleName;
            return $user;
        });

        return response()->json([
            'data' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
        ]);
    }

}
