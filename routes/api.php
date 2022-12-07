<?php

use App\Http\Controllers\API\V1\Backend\AuthController;
use App\Http\Controllers\API\V1\Frontend\AuthController as FrontendAuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('backend/login', [AuthController::class, 'login']);
    Route::post('frontend/login', [FrontendAuthController::class, 'login']);

    Route::group(['middleware' => 'jwt.verify'], function(){
        Route::prefix('backend')->group(function(){
            Route::get('profile', [AuthController::class, 'profile']);
        });

        Route::prefix('frontend')->group(function(){
            Route::get('profile', [FrontendAuthController::class, 'profile']);
        });
    });
});