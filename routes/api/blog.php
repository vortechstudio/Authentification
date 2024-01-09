<?php
use Illuminate\Support\Facades\Route;

Route::prefix('blog')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\Social\BlogController::class, 'all']);
    Route::get('/search', [\App\Http\Controllers\Api\Social\BlogController::class, 'search']);
    Route::get('/{id}', [\App\Http\Controllers\Api\Social\BlogController::class, 'info']);
});
