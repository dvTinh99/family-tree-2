<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyTreeController;
use App\Http\Controllers\FileController;

Route::get('/test', function() {
    return 'ok';
});

Route::middleware('auth:api')->group(function () {

    Route::get('/family-tree', [FamilyTreeController::class, 'index']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::get('/upload/generate-url', [FileController::class, 'generateUrl']);
