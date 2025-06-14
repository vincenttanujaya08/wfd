<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\{
    AuthController,
    LoginController,
    ReplyController,
    SignupController,
    PostController,
    TopicController,
    ExploreController,
    CommentController,
    NotificationController,
    FollowController,
    ProfileController,
    UserController
};
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Route (no authentication required)
Route::view('/', 'home')->name('home')->middleware('guest');
Route::view('/home', 'home')->middleware('guest');
Route::view('/load', 'load')->name('load');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Explore
    Route::view('/explore', 'explore')->name('explore');

    // User's Home
    Route::get('/homee', [PostController::class, 'home'])->name('homee');

    // Posts
    Route::get('/upload', [PostController::class, 'create'])->name('upload');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/like', [PostController::class, 'likePost'])->name('posts.like');
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment'])->name('posts.comments.add');
    Route::patch('/posts/{post}/edit', [PostController::class, 'editCaption'])->name('posts.editCaption');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::patch('/posts/{post}/toggle-status', [PostController::class, 'toggleStatus'])->name('posts.toggleStatus');
    Route::get('/posts/{postId}/comments', [CommentController::class, 'fetchComments'])->name('comments.fetch');

    // Comments & Replies
    Route::delete('/comments/{commentId}', [CommentController::class, 'deleteComment']);
    Route::delete('/replies/{replyId}', [ReplyController::class, 'deleteReply']);
    Route::post('/comments/{commentId}/like', [CommentController::class, 'likeComment'])->name('comments.like');
    Route::post('/comments/{commentId}/replies', [ReplyController::class, 'store'])->name('replies.store');
    Route::get('/comments/{commentId}/replies', [ReplyController::class, 'fetchReplies'])->name('replies.fetch');

    // Follow/Unfollow
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::get('/get-followers', [FollowController::class, 'getFollowers']);
    Route::get('/get-following', [FollowController::class, 'getFollowing']);

    // User Search
    Route::get('/search-users', [ProfileController::class, 'searchUsers'])->name('users.search');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Notifications
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notification', [NotificationController::class, 'getNotifications'])->name('notification');
    Route::post('/clear-notifications', [NotificationController::class, 'clearNotifications'])->name('clear.notifications');

    // Hidden Comments
    Route::patch('/comments/{id}/hide', [PostController::class, 'hideComment'])->name('comments.hide');
    Route::get('/posts/{id}/hidden-comments', [PostController::class, 'getHiddenComments'])->name('posts.hidden-comments');
    Route::patch('/comments/{id}/unhide', [PostController::class, 'unhideComment'])->name('comments.unhide');
});

// Guest (not logged in) routes for Login & Signup
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('/signup', [SignupController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [SignupController::class, 'processSignup'])->name('signup.post');
});

// Logout (needs auth)
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Public posts & details (no auth required)
Route::get('/posts', [PostController::class, 'fetchPosts'])->name('posts.fetch');
Route::get('/posts/{id}/details', [PostController::class, 'getDetails']);

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
            'name'          => $user->name,
            'profile_image' => $user->profile_image,
            'description'   => $user->description,
        ]);
    }
    return response()->json(['error' => 'User not found'], 404);
});

// Database Test Route
Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is OK!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});
