<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PostController;
use App\Http\Controllers\ThumbnailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthenticationController::class, 'login']);

Route::prefix('/thumbnails')->group(function () {
    Route::get('/{id}', [ThumbnailController::class, 'show']);
});

Route::prefix('/posts')->group(function () {
    Route::get('/{id}', [PostController::class, 'show']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthenticationController::class, 'logout']);

    Route::prefix('/posts')->group(function () {
        Route::get('/', [PostController::class, 'index']);
        Route::post('/', [PostController::class, 'store']);
        Route::patch('/{id}', [PostController::class, 'update']);
        Route::delete('/{id}', [PostController::class, 'destroy']);
    });

    Route::prefix('/thumbnails')->group(function () {
        Route::post('/', [ThumbnailController::class, 'store']);
    });
});
