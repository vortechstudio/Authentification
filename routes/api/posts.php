<?php
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\Social\PostController::class, 'all']);
    Route::post('/', [\App\Http\Controllers\Api\Social\PostController::class, 'store']);
    Route::get('{id}', [\App\Http\Controllers\Api\Social\PostController::class, 'info']);
    Route::put('{id}', [\App\Http\Controllers\Api\Social\PostController::class, 'update']);
    Route::get('/tags/all', [\App\Http\Controllers\Api\Social\PostController::class, 'tags']);
    Route::post('/{id}/like', [\App\Http\Controllers\Api\Social\PostController::class, 'like']);
    Route::post('/{id}/unlike', [\App\Http\Controllers\Api\Social\PostController::class, 'unlike']);
    Route::delete('{id}', [\App\Http\Controllers\Api\Social\PostController::class, 'destroy']);
});
