<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LocationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('users/sign-in', 'login');
    Route::post('users/sign-up', 'register');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index');
    Route::get('product/{id}', 'show')->where('id', '[0-9]+');
    Route::post('product', 'store');
    Route::put('product/edit/{id}', 'update');
    Route::delete('product/delete/{id}', 'delete');
});

Route::controller(LocationController::class)->group(function() {
    Route::get('location', 'index');
    Route::get('location/{id}', 'getById');
    Route::post('location', 'store');
    Route::put('location/edit/{id}', 'update');
    Route::delete('location/delete/{id}', 'delete');
});
