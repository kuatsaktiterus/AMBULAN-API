<?php

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

Route::post('login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('register', [App\Http\Controllers\Auth\AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);

    // order
    Route::post('store-order', [App\Http\Controllers\Order\OrderController::class, 'storeOrder']);
    Route::post('check-order', [App\Http\Controllers\Order\OrderController::class, 'checkOrder']);
    Route::post('check-on-process-order', [App\Http\Controllers\Order\OrderController::class, 'isOnProcessOrder']);
});
