<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Use DB for manual queries
use App\Models\User;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        $currentUserId = Auth::id();

        if ($currentUserId === $user->id) {
            return redirect()->back()->withErrors('You cannot follow yourself.');
        }

        $exists = DB::table('user_followers')
            ->where('user_id', $user->id)
            ->where('follower_id', $currentUserId)
            ->exists();

        if (!$exists) {
            
            DB::table('user_followers')->insert([
                'user_id' => $user->id,
                'follower_id' => $currentUserId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', "You are now following {$user->name}.");
    }

   
    public function unfollow(User $user)
    {
        $currentUserId = Auth::id();

        DB::table('user_followers')
            ->where('user_id', $user->id)
            ->where('follower_id', $currentUserId)
            ->delete();

        return redirect()->back()->with('success', "You have unfollowed {$user->name}.");
    }
}
