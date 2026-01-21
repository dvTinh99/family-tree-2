<?php

use Illuminate\Support\Facades\Route;

Route::domain('app.{any}')->group(function () {
    Route::get('{any}', function () {
        return view('welcome');
    })->where('any', '.*');
});

Route::get('/', function () {
    return view('landing');
});
