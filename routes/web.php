<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function(){
    return view('home');
})->middleware('auth')->name('dashboard');

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');