<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// Home Route (no authentication required)
Route::get('/', function () {
    if (Auth::check()) {
        // Redirect the logged-in user to /explore
        return redirect()->route('explore');
    }
    return view('home');
});

// Explore Page (accessible to all)
Route::get('/explore', function () {
    return view('explore');
})->name('explore');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Home Page - Display User's Posts
    Route::get('/homee', [PostController::class, 'home'])->name('homee');

    // Upload Post Form
    Route::get('/upload', [PostController::class, 'create'])->name('upload');

    // Handle form submission
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Like or unlike a post
    Route::post('/posts/{post}/like', [PostController::class, 'likePost'])->name('posts.like');

    // Add a comment to a post
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment'])->name('posts.comments.add');

    // Edit Post Caption via AJAX
    Route::patch('/posts/{post}/edit', [PostController::class, 'editCaption'])->name('posts.editCaption');
    
    // Delete Post via AJAX
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Fetch Comments for a Post
    Route::get('/posts/{postId}/comments', [CommentController::class, 'fetchComments'])->name('comments.fetch');

    // Logout Route
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Guest Routes (no authentication required)
Route::middleware('guest')->group(function() {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Signup Routes
    Route::get('/signup', [SignupController::class, 'showSignup'])->name('signup'); 
    Route::post('/signup', [SignupController::class, 'processSignup'])->name('signup.post');
});

// Posts Fetch Route (seems like an API route, pertimbangkan memindahkannya ke api.php)
Route::get('/posts', [PostController::class, 'fetchPosts'])->name('posts.fetch');

// Topics and Users Routes (menghindari duplikasi)
Route::prefix('/api')->group(function () {
    // Topics Routes
    Route::get('/topics', [TopicController::class, 'getTopics']);
    Route::get('/topics/search', [TopicController::class, 'search']);

    // Users Routes
    Route::get('/users', [TopicController::class, 'getUsers']);
});

// Database test route (for checking DB connection)
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is OK!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});
