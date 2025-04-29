<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);

Route::group(['middleware' => [\App\Http\Middleware\JWTVerify::class]], function () {

    Route::group(['prefix' => 'category'], function () {
        Route::post('/', [\App\Http\Controllers\CategoryController::class, 'create']);
        Route::get('/', [\App\Http\Controllers\CategoryController::class, 'findAll']);
        Route::get('/{id}', [\App\Http\Controllers\CategoryController::class, 'findByID']);
        Route::put('/{id}', [\App\Http\Controllers\CategoryController::class, 'patch']);
    });
});
