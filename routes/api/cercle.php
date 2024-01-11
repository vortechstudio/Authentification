<?php
use Illuminate\Support\Facades\Route;

Route::prefix('cercles')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\Social\CercleController::class, 'all']);
});
