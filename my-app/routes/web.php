<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/survey', function () {
    return view('survey');
})->middleware(['auth', 'verified'])->name('survey');

Route::get('/home', function () {
    return view('home'); 
})->name('home');


Route::get('/history-page', [HistoryController::class, 'show'])->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/user/update', [UserController::class, 'updateMultiple'])->name('user.update.multiple');
    Route::get('/history', [HistoryController::class, 'index']); // 履歴の取得
    Route::post('/history', [HistoryController::class, 'store'])->name('history.store'); // 履歴の追加
    Route::put('/history', [HistoryController::class, 'update'])->name('history.update'); // 履歴の追加
    Route::post('/user/increment-achieved-day', [UserController::class, 'incrementAchievedDay'])
    ->name('user.increment.achieved_day'); //achievedの更新
});


require __DIR__.'/auth.php';
