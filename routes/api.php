<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1')->group(function () {
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/users', UserController::class);

    Route::prefix('/carts')->group(function () {
        Route::get('/{userId}', [CartController::class, 'index']);
        Route::post('/', [CartController::class, 'store']);
        Route::put('/{userId}/items/{cartItemId}', [CartController::class, 'update']);
        Route::delete('/{userId}/items/{cartItemId}', [CartController::class, 'destroy']);
    });

    Route::prefix('/orders')->group(function () {
        Route::get('/{userId}', [OrderController::class, 'index']);
        Route::get('/{userId}/{orderId}', [OrderController::class, 'show']);
    });

    Route::post('/register', RegisterController::class)->name('register');
    Route::post('/login', LoginController::class)->name('login');
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::middleware('auth:api')->group(function () {
        Route::post('/create-order', [OrderController::class, 'createOrderFromCart']);
        Route::get('/user', function (Request $request) {
            return new UserResource($request->user());
        });
        Route::get('/orders', [OrderController::class, 'getUserOrders']);
        Route::get('/orders/{orderId}', [OrderController::class, 'getOrder']);
    });
});




