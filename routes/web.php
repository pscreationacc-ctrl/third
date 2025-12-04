<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\feedsyncController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/public-video', [feedsyncController::class, 'publicVideo'])->name('public.video');

Route::middleware('auth')->group(function () {


});
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('dashboard/api/manual-posts', [ feedsyncController::class, 'showfrontend' ])->name('feedsync.social');
    Route::post('dashboard/api/manual-posts', [ feedsyncController::class, 'savedata' ])->name('feedsync.save');
    Route::get('dashboard/api/manual-posts/learning',[feedsyncController::class, 'test'])->name('feedsync.learning');
    Route::get('api/manual-posts/history',[feedsyncController::class, 'history'])->name('feedsync.history');
    Route::delete('api/manual-posts/history/{id}',[feedsyncController::class, 'delete'])->name('feedsync.delete');
    Route::get('api/manual-posts/history/details/{id}',[feedsyncController::class, 'details'])->name('feedsync.details');
    Route::get('/dashboard/api/manual-posts/testing',[feedsyncController::class, 'testing'])->name('testing');
    Route::get('/testing',[feedsyncController::class, 'test'])->name('testing');
    Route::get('/dashboard/api/manual-posts/learning',[feedsyncController::class, 'learning'])->name('learning');
    Route::get('/view',[feedsyncController::class, 'view'])->name('view');
    
require __DIR__.'/auth.php';
