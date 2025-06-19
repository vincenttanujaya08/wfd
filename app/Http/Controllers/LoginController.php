<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{


    public function showLoginForm()
    {
        // Check if the user is already logged in
        if (Auth::check()) {
            // Redirect the logged-in user to /app
            return redirect()->route('app');
        }

        // Show the login form if the user is not logged in
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // 1. Ambil warning terbaru yang belum dibaca
            $warning = $user->warnings()
                ->where('seen', 0)
                ->latest('created_at')
                ->first();

            if ($warning) {
                // 2. Flash ke session agar bisa ditampilkan di blade
                Session::flash('warning_message', $warning->message);

                // 3. Tandai warning ini sudah seen
                $warning->update(['seen' => 1]);
            }

            // 4. Redirect berdasarkan role
            if ($user->role_id === 1) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('explore');
        }

        return back()
            ->withErrors(['email' => 'Credentials incorrect'])
            ->withInput($request->only('email', 'remember'));
    }




    public function logout()
    {
        Auth::logout(); // Log the user out

        // Redirect to the login page after logout
        return redirect(route('login')); // Replace with your login route
    }
}
