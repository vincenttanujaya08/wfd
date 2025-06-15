<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportImage;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Show the search + (later) report form on one page, with pagination.
     */
    public function show(Request $request)
    {
        $authId = Auth::id();
        $q      = $request->input('q', '');

        // Base query excludes self & admin
        $query = User::where('id', '!=', $authId)
            ->where('role', '!=', 'admin');

        if ($q) {
            $query->where('name', 'like', "%{$q}%");
        }

        // Paginate 10 per page, keep query string
        $users = $query->paginate(10)->withQueryString();

        return view('report', compact('users', 'q'));
    }

    /**
     * Handle the AJAX submission of the report.
     */
    public function sendReport(Request $request)
    {
        try {
            $request->validate([
                'reported_user_id' => 'required|exists:users,id|not_in:' . Auth::id(),
                'description'      => 'required|string|max:1000',
                'images.*'         => 'nullable|image|max:2048',
            ]);

            // Create the report
            $report = Report::create([
                'reporter_id'      => Auth::id(),
                'reported_user_id' => $request->reported_user_id,
                'description'      => $request->description,
                'status'           => 'pending',
            ]);

            // Store up to 5 images
            if ($request->hasFile('images')) {
                // Collect and take first 5
                $images = collect($request->file('images'))->take(5);
                foreach ($images as $img) {
                    $path = $img->store('report_images', 'public');
                    ReportImage::create([
                        'report_id'  => $report->id,
                        'image_path' => $path,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Your report has been submitted successfully.',
            ]);
        } catch (\Exception $e) {
            throw $e;
            Log::error('ReportController@sendReport failure', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
                // Optionally: 'files' => array_keys($request->allFiles()),
            ]);

            // 2) Return the raw message back to the client
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function searchUsers(Request $request)
    {
        $authId = Auth::id();
        $q      = $request->input('q', '');

        $query = User::where('id', '!=', $authId)
            ->where('role', '!=', 'admin');

        if ($q) {
            $query->where('name', 'like', "%{$q}%");
        }

        // ← paginate instead of get()
        $users = $query
            ->select('id', 'name', 'profile_image')
            ->paginate(5);

        // Return the full paginator as JSON
        return response()->json($users);
    }
}
