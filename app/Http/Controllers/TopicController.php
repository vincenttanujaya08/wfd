<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends Controller
{
    /**
     * Search for topics based on a query string.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([], 200);
        }

        // Search for topics that contain the query string, case-insensitive
        $topics = Topic::where('name', 'LIKE', '%' . $query . '%')
                        ->limit(10) // Limit to 10 suggestions
                        ->get(['id', 'name']);

        return response()->json($topics, 200);
    }
}
