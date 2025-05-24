<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
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

Route::get('/home', function () {
    if (Auth::check()) {
        return redirect()->route('explore');
    }
    return view('home');
});



Route::get('/load', function () {
    return view('load');
})->name('load');

// Route::get('/notification', function () {
//     return view('notification');
// })->name('notification');

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    // Explore Page
    Route::get('/explore', function () {
        return view('explore');
    })->name('explore');

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

    Route::get('/posts/{postId}/comments', [CommentController::class, 'fetchComments'])->name('comments.fetch');

    // Follow/Unfollow
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow.ajax');
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow.ajax');

    // User Search
    Route::get('/search-users', [ProfileController::class, 'searchUsers'])->name('users.search');

    // Followers/Following
    Route::get('/get-followers', [FollowController::class, 'getFollowers']);
    Route::get('/get-following', [FollowController::class, 'getFollowing']);

    // Comment & Reply Deletion
    Route::delete('/comments/{commentId}', [CommentController::class, 'deleteComment'])->middleware('auth');
    Route::delete('/replies/{replyId}', [ReplyController::class, 'deleteReply'])->middleware('auth');
});

// Profile
Route::get('/profile', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile.show');

Route::post('/profile/update', [ProfileController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

// Login & Logout Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    // Signup Route
    Route::get('/signup', [SignupController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [SignupController::class, 'processSignup'])->name('signup.post');
});

// Logout Route (needs auth)
Route::post('logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Public Posts & Details
Route::get('/posts', [PostController::class, 'fetchPosts'])->name('posts.fetch');
Route::get('/posts/{id}/details', [PostController::class, 'getDetails']);

// Hidden Comments
Route::patch('/comments/{id}/hide', [PostController::class, 'hideComment'])->name('comments.hide');
Route::get('/posts/{id}/hidden-comments', [PostController::class, 'getHiddenComments'])->name('posts.hidden-comments');
Route::patch('/comments/{id}/unhide', [PostController::class, 'unhideComment'])->name('comments.unhide');

// Notifications
Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
Route::get('/notification', [NotificationController::class, 'getNotifications'])->name('notification');
Route::post('/clear-notifications', [NotificationController::class, 'clearNotifications'])->name('clear.notifications');

// Post Status Toggle
Route::patch('/posts/{post}/toggle-status', [PostController::class, 'toggleStatus'])->name('posts.toggleStatus');

// Replies
Route::post('/comments/{commentId}/replies', [ReplyController::class, 'store'])->name('replies.store');
Route::get('/comments/{commentId}/replies', [ReplyController::class, 'fetchReplies'])->name('replies.fetch');

// Comment Like (Auth)
Route::middleware(['auth'])->group(function () {
    Route::post('/comments/{commentId}/like', [CommentController::class, 'likeComment'])->name('comments.like');
});

// Follow/Unfollow (Duplication)
Route::post('/follow/{user}', [FollowController::class, 'follow'])
    ->middleware('auth')
    ->name('follow');
Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])
    ->middleware('auth')
    ->name('unfollow');

// Database Test Route
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is OK!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

// Topics
Route::get('/topics/all', [TopicController::class, 'indexAll']);
Route::get('/topics/all-shuffled', [TopicController::class, 'indexAllShuffled']);
Route::get('/topics/search', [TopicController::class, 'search']);

// Users
Route::get('/users/all', [UserController::class, 'indexAll']);
Route::get('/users/all-shuffled', [UserController::class, 'indexAllShuffled']);
Route::get('/users/search', [UserController::class, 'search']);

// Fetch Posts by Topic or User
Route::get('/posts/topic/{topicName}', [PostController::class, 'fetchPostsByTopic']);
Route::get('/posts/user/{username}', [PostController::class, 'fetchPostsByUsername']);

// User Details Endpoint
Route::get('/user-details/{id}', function ($id) {
    $user = User::find($id);

    if ($user) {
        return response()->json([
            'name'            => $user->name,
            'profile_image'   => $user->profile_image,
            'description'     => $user->description,
        ]);
    }

    return response()->json(['error' => 'User not found'], 404);
});
