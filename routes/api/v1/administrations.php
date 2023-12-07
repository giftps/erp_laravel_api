<?php

namespace App\Http\Controllers\Api\V1\Administrations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for employer groups
|
*/

Route::prefix('/v1/administrations')->middleware(['auth:api', 'role:Super Admin'])->group(function(){
    Route::get('/period-scheme-prices/{year}/{scheme_id}', [SchemeAndBenefitPricesController::class, 'schemePrices']);
    Route::post('/add-update-scheme-price', [SchemeAndBenefitPricesController::class, 'AddUpdateSchemePrice']);
    Route::get('/scheme-benefit-prices/{year}/{scheme_option_id}', [SchemeAndBenefitPricesController::class, 'benefitPrices']);
    Route::post('/add-scheme-benefit-price', [SchemeAndBenefitPricesController::class, 'addUpdateSchemeBenefitAmount']);

    // Imports and import progresses
    Route::post('/import-scheme-subscription-prices', [SchemeAndBenefitPricesController::class, 'importSchemeSubscriptions']);
    Route::get('/scheme-subscription-import-progress', [SchemeAndBenefitPricesController::class, 'SchemeSubscriptionsImportProgress']);

    Route::post('/import-scheme-benefit-prices', [SchemeAndBenefitPricesController::class, 'importSchemeBenefitPrices']);
    Route::get('/scheme-benefit-prices-import-progress', [SchemeAndBenefitPricesController::class, 'SchemeBenefitPricesImportProgress']);
});