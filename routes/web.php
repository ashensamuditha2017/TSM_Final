<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\GoogleDataController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Public Welcome Page (the root of your application)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// The main application home page (dashboard), protected by the 'auth' middleware.
Route::get('/home', function () {
    return view('dashboard');
})->middleware('auth')->name('home');

// Login and Register routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Google Socialite Routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callbackGoogle']);

// Custom logout route
Route::post('logout', [GoogleAuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/calendar', [GoogleDataController::class, 'showCalendar'])->name('calendar');
    Route::get('/email', [GoogleDataController::class, 'showEmails'])->name('email');
    Route::get('/todos', [GoogleDataController::class, 'showToDos'])->name('todos');
});