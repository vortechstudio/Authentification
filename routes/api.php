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

Route::post('/update', function (Request $request) {
    \Salahhusa9\Updater\Facades\Updater::update();
});

Route::get('/update/check', function () {
    return response()->json([
        "latest" => \Salahhusa9\Updater\Facades\Updater::getLatestVersion()
    ]);
});
Route::prefix('auth')->group(function () {
    Route::post('/login', \App\Http\Controllers\Api\Auth\LoginController::class);
    Route::post('/logout', \App\Http\Controllers\Api\Auth\LogoutController::class);
    Route::post('/register', \App\Http\Controllers\Api\Auth\RegisterController::class);
    Route::get('/sso', \App\Http\Controllers\Api\Auth\SsoController::class);
});

Route::prefix('user')->group(function () {
    Route::get('/profil', [\App\Http\Controllers\Api\User\ProfilController::class, 'index']);
});

Route::prefix('calcul')->group(function () {
    Route::get('/estimate/essieux', [\App\Http\Controllers\Api\CalculController::class, 'estimateEssieux']);
});

Route::prefix('engines')->group(function () {
    Route::post('/{id}/upload', [\App\Http\Controllers\Api\EngineController::class, 'upload']);
});
