<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportImage;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman report + search user (paginated).
     * Route: GET /report
     */
// app/Http/Controllers/ReportController.php

public function show(Request $request)
{
    $authId = Auth::id();
    $q      = trim($request->input('q',''));

    $query = User::where('id','!=',$authId)
                 // kecualikan admin (role_id = 1)
                 ->where('role_id','!=', 1);

    if ($q!=='') {
        $query->where('name','like', "%{$q}%");
    }

    $users = $query
        ->select('id','name','profile_image')
        ->paginate(10)
        ->withQueryString();

    return view('report', compact('users','q'));
}

public function searchUsers(Request $request)
{
    $authId = Auth::id();
    $q      = trim($request->input('q',''));

    $query = User::where('id','!=',$authId)
                 ->where('role_id','!=',1);

    if ($q!=='') {
        $query->where('name','like', "%{$q}%");
    }

    $users = $query
        ->select('id','name','profile_image')
        ->paginate(5);

    return response()->json($users);
}


    /**
     * AJAX: submit report + up to 5 gambar.
     * Route: POST /report/send
     */
    public function sendReport(Request $request)
    {
        $request->validate([
            'reported_user_id' => "required|exists:users,id|not_in:".Auth::id(),
            'description'      => 'required|string|max:1000',
            'images.*'         => 'nullable|image|max:2048',
        ]);

        try {
            $report = Report::create([
                'reporter_id'      => Auth::id(),
                'reported_user_id' => $request->reported_user_id,
                'description'      => $request->description,
                'status'           => 'pending',
            ]);

            if ($request->hasFile('images')) {
                collect($request->file('images'))->take(5)
                    ->each(fn($img)=> ReportImage::create([
                        'report_id'  => $report->id,
                        'image_path' => $img->store('report_images','public'),
                    ]));
            }

            return response()->json([
                'success' => true,
                'message' => 'Report submitted successfully.',
            ]);
        }
        catch (\Throwable $e) {
            Log::error('ReportController@sendReport', ['msg'=>$e->getMessage()]);
            return response()->json([
                'success'=>false,
                'message'=>'Server error: '.$e->getMessage()
            ], 500);
        }
    }
}
