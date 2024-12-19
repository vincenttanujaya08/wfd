<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Route (no authentication required)
Route::get('/', function () {
    if (Auth::check()) {
        // Redirect the logged-in user to /app
        return redirect()->route('app');
    }
    return view('home');
});

// Protected Route - Only accessible if authenticated
Route::get('/app', function () {
    return view('app');
})->name('app')->middleware('auth');

Route::get('/comment', function () {
    return view('comment');
})->name('comment')->middleware('auth');

// Login Routes - Only accessible if not authenticated
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->middleware('guest');
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Signup Routes - Only accessible if not authenticated
Route::get('/signup', [SignupController::class, 'showSignup'])->name('signup')->middleware('guest');
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
