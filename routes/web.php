<?php


use App\Http\Controllers\ChirpController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', 'chirps')->name('dashboard');

    Route::resource('chirps', ChirpController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy']);

    Route::post('/chirps/{chirp}/like', [LikeController::class, 'toggle'])
        ->name('chirps.like');

    Route::post('/chirps/{chirp}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit.custom');

    Route::get('/profile/{user}', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/users/{user}/follow', [FollowController::class, 'toggle'])
        ->name('users.follow');
    
    Route::get('/feed', [FeedController::class, 'index'])
        ->name('feed.index');
});

require __DIR__.'/settings.php';
