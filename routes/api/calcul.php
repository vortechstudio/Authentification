<?php
use Illuminate\Support\Facades\Route;

Route::prefix('calcul')->group(function () {
    Route::get('/estimate/essieux', [\App\Http\Controllers\Api\CalculController::class, 'estimateEssieux']);
});
