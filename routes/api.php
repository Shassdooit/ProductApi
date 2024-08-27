<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);

    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', LoginController::class)->name('login');
    Route::post('refresh-token', [AuthController::class, 'refresh']);

    Route::middleware('auth:api')->group(function () {
        Route::prefix('carts')->group(function () {
            Route::get('{userId}', [CartController::class, 'index']);
            Route::post('/', [CartController::class, 'store']);
            Route::put('/items/{productId}', [CartController::class, 'update']);
            Route::delete('items/{cartItemId}', [CartController::class, 'destroy']);
        });

        Route::get('user', function (Request $request) {
            return new UserResource($request->user());
        });
        Route::post('logout', LogoutController::class);

        Route::post('create-order', [OrderController::class, 'createOrderFromCart']);
        Route::get('/orders', [OrderController::class, 'getUserOrders']);
        Route::get('/orders/{orderId}', [OrderController::class, 'getOrder']);

        Route::middleware(['role:admin,moderator'])->group(function () {
            Route::apiResource('products', ProductController::class)
                ->except(['index', 'show']);
            Route::put('orders/{orderId}/status', [OrderController::class, 'updateOrderStatus']);
        });

        Route::middleware(['role:admin'])->group(function () {
            Route::apiResource('users', UserController::class);
            Route::put('users/{id}/role', [UserController::class, 'updateUserRole']);
        });
    });
});




