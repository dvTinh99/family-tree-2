<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

Route::domain('app.{any}')->group(function () {
    Route::get('{any}', function () {
        return view('welcome');
    })->where('any', '.*');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi', 'es'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return redirect()->back();
});

Route::get('/', function () {
    $locale = session('locale', 'en');
    App::setLocale($locale);
    return view('landing');
});
Route::get('/login', function () {
    $locale = session('locale', 'en');
    App::setLocale($locale);
    return view('login');
});
Route::post('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/password/request', function () {
    return view('login');
})->name('password.request');
Route::post('/social/redirect', function () {
    return view('login');
})->name('social.redirect');

Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);
