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
        Route::delete('/{id}', [\App\Http\Controllers\CategoryController::class, 'delete']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::post('/', [\App\Http\Controllers\ProductController::class, 'create']);
        Route::get('/', [\App\Http\Controllers\ProductController::class, 'findAll']);
        Route::get('/{id}', [\App\Http\Controllers\ProductController::class, 'findByID']);
        Route::post('/{id}', [\App\Http\Controllers\ProductController::class, 'patch']);
        Route::delete('/{id}', [\App\Http\Controllers\ProductController::class, 'delete']);
    });
});
