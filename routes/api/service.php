<?php
use Illuminate\Support\Facades\Route;

Route::prefix('services')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\ServiceController::class, 'all']);
    Route::get('/{id}', [\App\Http\Controllers\Api\ServiceController::class, 'info']);
});
