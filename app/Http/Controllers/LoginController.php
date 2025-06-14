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
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Ambil user yang login
            $user = Auth::user();

            // Cek rolenya
            if ($user->role === 'admin') {
                // Redirect ke halaman admin
                return redirect()->route('admin.dashboard');
            } else {
                // Redirect ke halaman user biasa
                return redirect()->intended(route('load'));
            }
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])->withInput($request->only('email', 'remember'));
    }




    public function logout()
    {
        Auth::logout(); // Log the user out

        // Redirect to the login page after logout
        return redirect(route('login')); // Replace with your login route
    }
}
