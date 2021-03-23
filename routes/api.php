<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeController;
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
     * Protected routes,
     * need to include headers:
     *      Accept: application/json
     *      Authorization: Bearer $token
     * on http request.
     */
    Route::group(['middleware' => ['auth:sanctum']], function () {

        //
        Route::group(['prefix' => 'posts/{post}/likes'], function () {
            Route::get('/', [LikeController::class, 'getByPost']);
            Route::post('/', [LikeController::class, 'store']);
            Route::delete('/{user_id}', [LikeController::class, 'deleteByPost']);
        });

        /**
         * User Profile and Settings
         *
         */
        Route::group(['prefix' => 'profile'], function () {

        });

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
