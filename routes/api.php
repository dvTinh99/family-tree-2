<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyTreeController;

Route::get('/test', function() {
    return 'ok';
});

Route::get('/family-tree', [FamilyTreeController::class, 'index']);
