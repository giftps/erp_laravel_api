<?php

namespace App\Http\Controllers\Api\V1\Financials;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Lookups\AuthTypesController;

use App\Http\Controllers\Api\V1\Membership\MembersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for when the financials
|
*/

Route::prefix('/v1/financials-and-reports')->middleware(['auth:api'])->group(function(){
    Route::apiResource('/premium-payments', PremiumPaymentsController::class);
    Route::get('/families/{search}', [PremiumPaymentsController::class, 'searchFamily']);
    Route::post('/premium-excel-import', [PremiumPaymentsController::class, 'premiumPaymentImports']);
});