<?php
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/login', \App\Http\Controllers\Api\Auth\LoginController::class);
    Route::post('/logout', \App\Http\Controllers\Api\Auth\LogoutController::class);
    Route::post('/register', \App\Http\Controllers\Api\Auth\RegisterController::class);
    Route::get('/sso', \App\Http\Controllers\Api\Auth\SsoController::class);
});
