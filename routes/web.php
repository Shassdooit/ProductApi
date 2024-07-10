<?php

use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/my_page', [OrderController::class, 'index']);
Route::get('/my_page/create', [UserController::class, 'create']);
Route::get('/my_page/update', [UserController::class, 'update']);
Route::get('/my_page/delete', [UserController::class, 'delete']);
Route::get('/my_page/first_or_create', [UserController::class, 'firstOrCreate']);
Route::get('/my_page/update_or_create', [UserController::class, 'updateOrCreate']);
