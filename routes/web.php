<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// Home Route (no authentication required)
Route::get('/', function () {
    if (Auth::check()) {
        // Redirect the logged-in user to /app
        return redirect()->route('explore');
    }
    return view('home');
});


Route::get('/explore', function () {
    return view('explore');
})->name('explore')->middleware('auth');

Route::get('/homee', function () {
    return view('homee');
})->name('homee')->middleware('auth');

Route::get('/upload', function () {
    return view('upload');
})->name('upload')->middleware('auth');

// Login & Logout Routes
// Login Route - Only accessible if not authenticated (using guest middleware)
// Namun di contoh ini tidak ditambahkan guest middleware, tapi idealnya:
// Route::middleware('guest')->group(function() {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
// });

Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Signup Route
Route::get('/signup', [SignupController::class, 'showSignup'])->name('signup'); 
Route::post('/signup', [SignupController::class, 'processSignup'])->middleware('guest');

// Database test route (for checking DB connection)
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is OK!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});
