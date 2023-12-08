<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', \App\Http\Controllers\Api\Auth\LoginController::class);
    Route::post('/logout', \App\Http\Controllers\Api\Auth\LogoutController::class);
    Route::post('/register', \App\Http\Controllers\Api\Auth\RegisterController::class);
});

Route::middleware(['api'])->prefix('user')->group(function () {
    Route::get('/profil', [\App\Http\Controllers\Api\User\ProfilController::class, 'index']);
});
