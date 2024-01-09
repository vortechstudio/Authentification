<?php
use Illuminate\Support\Facades\Route;

Route::prefix('pages')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\ServiceController::class, 'all']);
});
