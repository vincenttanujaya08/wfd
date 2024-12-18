<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('home');
});
<<<<<<< Updated upstream
Route::get('/login', function () {
    return view('login');
});
Route::get('/signup', function () {
    return view('signup');
});
=======



// Protected Route - Only accessible if authenticated
Route::get('/app', function () {
    return view('app');
})->name('app')->middleware('auth');

Route::get('/comment', function () {
    return view('comment');
})->name('comment')->middleware('auth');



// Login Route - Only accessible if not authenticated (using guest middleware)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\SignupController;

Route::get('/signup', [SignupController::class, 'showSignup'])->name('signup'); 
Route::post('/signup', [SignupController::class, 'processSignup'])->middleware('guest'); 





// Database test route (for checking DB connection)
>>>>>>> Stashed changes
use Illuminate\Support\Facades\DB;

    Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is OK!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

