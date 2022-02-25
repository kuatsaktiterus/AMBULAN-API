<?php

use App\Events\TestEvents;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiOrder;
use App\Http\Controllers\Api\ApiOrder\ApiProcessOrder;
use App\Http\Controllers\Api\ApiAuth;
use App\Http\Controllers\Api\ApiDriver;
use App\Http\Controllers\Api\ApiCustomer;
use Illuminate\Support\Facades\Broadcast;

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

Broadcast::routes(['middleware' => ['auth:sanctum']]);
Route::post('login', [ApiAuth\ApiAuthControllerApi::class, 'login']);
Route::post('register', [ApiAuth\ApiAuthControllerApi::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Route::post('/sender', function()
    // {
    //     $text = request()->text;
    //     event(new TestEvents($text));
    // });

    Route::post('logout', [ApiAuth\ApiAuthControllerApi::class, 'logout'])->middleware('ability:customer,driver');

    Route::middleware('abilities:customer')->group(function ()
    {
        // order
        // Perform By Customer
        // ApiOrderController Handle

        /**
         *  1. Customer perform to send order to server
        */ 
        Route::post('store-order', [ApiOrder\ApiOrderController::class, 'store']);

        /**
         *  4. Customer will check the order is accepted or not in here
         */
        Route::post('check-accepted-order', [ApiOrder\ApiOrderController::class, 'checkAcceptedOrder']);

        // ApiProcessOrderController Handle
        // Perform By Customer
        
        /** 
         * 2. After orderring from app request for driver
        */
        Route::post('get-driver', [ApiProcessOrder\ApiProcessOrderController::class, 'getDriver']);
        // Checking if there is active order that not finished yet
        Route::post('check-on-process-order', [ApiProcessOrder\ApiProcessOrderController::class, 'isOnProcessOrder']);

        // Customer
        // update customer location
        Route::post('update-customer-location', [ApiCustomer\ApiCustomerController::class, 'LocationUpdate']);
    });


    Route::middleware('abilities:driver')->group(function ()
    {
        // ApiProcessOrderController Handle
        // Perform By Driver

        /** 
         *  3. Determine if Driver is accepting order or not, 
         *  If order accepted, then it will be go for next process 
         *  If not accepted it will go for previous step to get driver.
        */
        Route::post('accept-order', [ApiProcessOrder\ApiProcessOrderController::class, 'isAcceptOrder']);
        /**
         * 5. Driver will change the status of order depending the situation(['searching', 'rejected', 'accepted', 'on_pick_up_location', 'on_the_way', 'on_drop_off_location', 'dropped'])
         */
        Route::post('change-status-order', [ApiProcessOrder\ApiProcessOrderController::class, 'changeStatusOrder']);

        // Driver
        // update driver location
        Route::post('update-driver-location', [ApiDriver\ApiDriverController::class, 'LocationUpdate'])->middleware('abilities:driver');
    });


});
