<?php

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
