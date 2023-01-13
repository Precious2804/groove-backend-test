<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['json.response']], function () {

    // Unauthenticated Routes

    Route::group(['prefix' => 'auth', 'middleware' => ['json.response']], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    //authenticated routes
    Route::group(['middleware' => ['auth:api', 'json.response']], function () {
        Route::get('account/my-profile', [UserController::class, 'getProfile']);
        Route::post('account/change-password', [UserController::class, 'changePassword']);
        Route::post('account/update-profile', [UserController::class, 'updateProfile']);
        Route::get('account/my-investments', [UserController::class, 'myInvestments']);
        Route::post('token/buy-token/{project}', [UserController::class, 'buyToken']);
        Route::get('token/view-investment/{token}', [UserController::class, 'viewInvestment']);
    });

    Route::group(['middlware' => ['auth:api']], function () {
        Route::get('token/all-tokens', [MainController::class, 'allTokens']);
        Route::get('token/single-token/{token}', [MainController::class, 'getSingleToken']);
        Route::get('token/trans-on-token/{token}', [MainController::class, 'transOnToken']);
        Route::get('project/all-projects', [MainController::class, 'allProjects']);
        Route::get('project/single-project/{project}', [MainController::class, 'singleProject']);
    });

    //Admin Routes
    Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'admin']], function () {
        Route::get('all-users', [AdminController::class, 'getAllUsers']);
        Route::get('single-user/{user}', [AdminController::class, 'getSingleUser']);
        Route::post('create-project', [AdminController::class, 'createProject']);
        Route::get('all-investments', [AdminController::class, 'allInvestments']);
        Route::get('view-investment', [AdminController::class, 'viewInvestment']);
    });
});
