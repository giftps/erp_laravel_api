<?php

namespace App\Http\Controllers\Api\V1\Sales;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for the sales department
|
*/

Route::prefix('/v1/sales')->middleware(['auth:api', 'role:Sales Admin|Super Admin'])->group(function(){
    Route::apiResource('/broker-houses', BrokerHousesController::class);
    Route::post('/import-broker-houses', [BrokerHousesController::class, 'importBrokerHouses']);
    Route::apiResource('/brokers', BrokersController::class);
    Route::post('/import-brokers', [BrokersController::class, 'importBrokers']);
    Route::get('/family-quotations/{family_id}', [QuotationsController::class, 'familyQuotations']);
});