<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

// Public Meme Feed
Route::get('/', function () {
    $posts = Post::latest()->get();
    return view('blog', compact('posts'));
});

// Admin Login
Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $posts = Post::latest()->get();
        return view('dashboard', compact('posts'));
    });

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $posts = Post::latest()->get();
        return view('dashboard', compact('posts'));
    });

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/zip', [PostController::class, 'storeZip'])->name('posts.zip');
});