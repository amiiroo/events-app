<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FriendController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // API для ленты
    Route::get('/feed/event', [FeedController::class, 'getNextEvent']);
    Route::post('/feed/event/{event}/swipe', [FeedController::class, 'swipe']);

    // API для голосования
    Route::post('/favorites/event/{event}/vote', [FavoriteController::class, 'vote']);

    // API для поиска друзей
    Route::get('/friends/search', [FriendController::class, 'search']);
});