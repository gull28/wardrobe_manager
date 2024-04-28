<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\WardrobeController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\HomePageController;

Route::get('/', [HomePageController::class, 'index'])->name('home');


Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');

Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::resource('wardrobe', WardrobeController::class)->middleware('auth');
Route::post('/wardrobe/{clothing}/wash', [WardrobeController::class, 'wash'])->name('wardrobe.wash')->middleware('auth');

Route::resource('outfits', OutfitController::class)->middleware('auth');

// routes for day schedule
Route::get('/schedule/{day}', [ScheduleController::class, 'showDay'])->name('schedule.day')->middleware('auth');
Route::get('/schedule/{day}/wear', [ScheduleController::class, 'wear'])->name('schedule.wear')->middleware('auth');
Route::get('/schedule/{day}/wash', [ScheduleController::class, 'wash'])->name('schedule.wash')->middleware('auth');
Route::post('/schedule/{day}/wear', [ScheduleController::class, 'storeWear'])->middleware('auth');
Route::post('/schedule/{day}/wash', [ScheduleController::class, 'storeWash'])->middleware('auth');