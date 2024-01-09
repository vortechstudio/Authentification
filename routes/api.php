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
        'latest' => \Salahhusa9\Updater\Facades\Updater::getLatestVersion(),
    ]);
});

include "api/auth.php";
include "api/engines.php";
include "api/calcul.php";
include "api/user.php";
include "api/blog.php";
include "api/service.php";
include "api/pages.php";
