<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\Admin\EventController as AdminEventController;

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/feed', [FeedController::class, 'index'])->name('feed');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function() { return redirect()->route('admin.events.index'); });
    Route::resource('events', AdminEventController::class);
});

require __DIR__.'/auth.php';