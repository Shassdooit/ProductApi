<?php

use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('users', UserController::class);

    Route::prefix('carts')->group(function () {
        Route::get('/{userId}', [CartController::class, 'index']);
        Route::post('/', [CartController::class, 'store']);
        Route::put('/{userId}/items/{cartItemId}', [CartController::class, 'update']);
        Route::delete('/{userId}/items/{cartItemId}', [CartController::class, 'destroy']);
    });
});



