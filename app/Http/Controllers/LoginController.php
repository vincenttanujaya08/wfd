<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

   if (Auth::attempt($request->only('email','password'), $request->remember)) {
    $user = Auth::user();

     if ($user->role_id === 1) {
            // Redirect ke route admin.dashboard (URL berubah ke /admin/dashboard)
            return redirect()->route('admin.dashboard');
        }

    return redirect()->route('explore');
}

    return back()
        ->withErrors(['email'=>'Credentials incorrect'])
        ->withInput($request->only('email','remember'));
}




    public function logout()
    {
        Auth::logout(); // Log the user out

        // Redirect to the login page after logout
        return redirect(route('login')); // Replace with your login route
    }
}
