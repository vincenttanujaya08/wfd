<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // For Query Builder

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Total posts by the user (assuming a Post model with user_id column)
        $totalPosts = DB::table('posts')->where('user_id', $user->id)->count();

        // Total followers
        $totalFollowers = DB::table('user_followers')->where('user_id', $user->id)->count();

        // Total following
        $totalFollowing = DB::table('user_followers')->where('follower_id', $user->id)->count();

        return view('profile', compact('user', 'totalPosts', 'totalFollowers', 'totalFollowing'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to log in to update your profile.');
        }

        // Validate incoming data with unique check for the name
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $userId,
            'description' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|url', // Ensure it's a valid URL
        ]);

        // Update user attributes directly in the database
        try {
            DB::table('users')->where('id', $userId)->update([
                'name'          => $request->input('name'),
                'description'   => $request->input('description'),
                'profile_image' => $request->input('profile_image'),
            ]);

            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while updating your profile. Please try again.');
        }
    }
}
