<?php

use App\Http\Controllers\Api\SearchController;
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

Route::middleware(['treblle'])->group(function () {
    Route::post('/update', function (Request $request) {

        \Salahhusa9\Updater\Facades\Updater::update();
    });

    Route::get('/update/check', function () {
        return response()->json([
            'latest' => \Salahhusa9\Updater\Facades\Updater::getLatestVersion(),
        ]);
    });

    Route::post('/search', [SearchController::class, 'index']);

    include_once "api/auth.php";
    include_once "api/engines.php";
    include_once "api/calcul.php";
    include_once "api/user.php";
    include_once "api/blog.php";
    include_once "api/service.php";
    include_once "api/pages.php";
    include_once "api/cercle.php";
    include_once "api/posts.php";
});
