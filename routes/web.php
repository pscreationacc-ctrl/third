<?php

use App\Http\Controllers\crudcontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\feedsyncController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/public-video', [feedsyncController::class, 'publicVideo'])->name('public.video');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('dashboard', [ feedsyncController::class, 'showfrontend' ])->name('feedsync.social');
    Route::post('dashboard', [ feedsyncController::class, 'savedata' ])->name('feedsync.save');
    Route::get('dashboard/learning',[feedsyncController::class, 'test'])->name('feedsync.learning');
    Route::get('api/history',[feedsyncController::class, 'history'])->name('feedsync.history');
    Route::delete('api/history/{id}',[feedsyncController::class, 'delete'])->name('feedsync.delete');
    Route::get('api/history/details/{id}',[feedsyncController::class, 'details'])->name('feedsync.details');
    Route::get('/dashboard/testing',[feedsyncController::class, 'testing'])->name('testing');
    Route::get('/testing',[feedsyncController::class, 'test'])->name('testing');
    Route::get('/dashboard/learning',[feedsyncController::class, 'learning'])->name('learning');
    Route::get('/view',[feedsyncController::class, 'view'])->name('view');
    route::get('/stream',[feedsyncController::class, 'stream'])->name('stream');
    Route::post('/python', [feedsyncController::class, 'ai']);
    Route::get('/api/conversation-history', [feedsyncController::class, 'getConversationHistory']);
});

route::get('/test',[crudcontroller::class,'index'])->name('crud.index');
route::post('/crudcreate',[crudcontroller::class,'crudcreate'])->name('crud.create');
route::get('/test/{id}/edit',[crudcontroller::class,'crudgetedit'])->name('crud.getedit');
route::put('/test/{id}/edit',[crudcontroller::class,'crudedit'])->name('crud.edit');
route::delete('/test/{id}/edit',[crudcontroller::class,'cruddelete'])->name('crud.delete');

require __DIR__.'/auth.php';
