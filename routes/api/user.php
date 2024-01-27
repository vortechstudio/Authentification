<?php
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('/profil', [\App\Http\Controllers\Api\User\ProfilController::class, 'index']);
    Route::put('/profil', [\App\Http\Controllers\Api\User\ProfilController::class, 'updateProfil']);
    Route::put('/profil/optin', [\App\Http\Controllers\Api\User\ProfilController::class, 'updateOptin']);
    Route::put('/profil/notifin', [\App\Http\Controllers\Api\User\ProfilController::class, 'updateNotifin']);
    Route::put('/status', [\App\Http\Controllers\Api\User\ProfilController::class, 'updateStatus']);
    Route::delete('/logout', [\App\Http\Controllers\Api\User\ProfilController::class, 'logout']);
    Route::delete('/uban', [\App\Http\Controllers\Api\User\ProfilController::class, 'uban']);
    Route::post('/ban', [\App\Http\Controllers\Api\User\ProfilController::class, 'ban']);

    Route::post('/avertissement', [\App\Http\Controllers\Api\User\ProfilController::class, 'avertissement']);
});
