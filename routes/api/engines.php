<?php
use Illuminate\Support\Facades\Route;

Route::prefix('engines')->group(function () {
    Route::post('/{id}/upload', [\App\Http\Controllers\Api\EngineController::class, 'upload']);
});
