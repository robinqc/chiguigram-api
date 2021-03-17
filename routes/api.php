<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')
    ->get('/user', function (Request $request) {
        return $request->user();
    });

/**
 * API v1
 */
Route::group(['prefix' => 'v1', 'middleware' => ['cors']], function () {

    /**
     * Protected routes
     */
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::apiResource('posts', PostController::class);
        Route::apiResource('users', UserController::class);
    });

    /**
     * Authentication Routes
     */
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
        Route::post('signup', [AuthController::class, 'signUp']);
    });

});
