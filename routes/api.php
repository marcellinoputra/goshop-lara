<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
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
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index');
    Route::get('product/{id}', 'show')->where('id', '[0-9]+');
    Route::post('product', 'store');
    Route::put('product/edit/{id}', 'update');
    Route::delete('product/delete/{id}', 'delete');
});
