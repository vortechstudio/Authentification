<?php
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('/profil', [\App\Http\Controllers\Api\User\ProfilController::class, 'index']);
    Route::put('/status', [\App\Http\Controllers\Api\User\ProfilController::class, 'updateStatus']);
});
