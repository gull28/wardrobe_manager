<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\WardrobeController;
use App\Http\Controllers\OutfitController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');

Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::resource('wardrobe', WardrobeController::class)->middleware('auth');
Route::post('/wardrobe/{clothing}/wash', [WardrobeController::class, 'wash'])->name('wardrobe.wash')->middleware('auth');

Route::resource('outfits', OutfitController::class)->middleware('auth');