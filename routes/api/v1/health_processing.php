<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Models\ImportProgress;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for health processing
|
*/

Route::prefix('/v1/health-processing')->middleware(['auth:api', 'role:Broker|Membership Admin|Super Admin'])->group(function(){
    Route::apiResource('/disciplines', DisciplinesController::class);
    Route::apiResource('/service-providers', ServiceProvidersController::class);
    Route::get('/service-provider-contacts', [ServiceProviderContactsController::class, 'index']);
    Route::get('/service-provider-contacts/{id}', [ServiceProviderContactsController::class, 'show']);
    Route::post('/service-provider-contacts', [ServiceProviderContactsController::class, 'store']);
    Route::put('/service-provider-contacts/{id}', [ServiceProviderContactsController::class, 'update']);
    Route::apiResource('/service-provider-payment-details', ServiceProviderPaymentDetailsController::class);
    Route::get('/service-provider-preauthorisations/{service_provider_id}', [ServiceProvidersController::class, 'serviceProviderPreauthorisations']);
    
    Route::apiResource('/service-provider-price-list', ServiceProviderPriceListsController::class);
    Route::post('/import-service-provider-price-list', [ServiceProviderPriceListsController::class, 'importPriceList']);
    Route::get('/service-provider-price-list-import-progress', [ServiceProviderPriceListsController::class, 'importProgress']);

    Route::apiResource('/service-types', ServiceTypesController::class);
    Route::apiResource('/product-or-service-price', ProductOrServicesController::class);
    Route::apiResource('/service-provider-documents', ServiceProviderDocumentsController::class);
    Route::get('/service-provider-services/{provider_id}', [ProductOrServicesController::class, 'providerServices']);

    Route::post('/import-service-providers', [ServiceProvidersController::class, 'importServiceProviders']);
    Route::get('/service-providers-import-progress', [ServiceProvidersController::class, 'importProgress']);


    Route::apiResource('/tariffs', TariffsController::class);
    Route::post('/import-tariffs', [TariffsController::class, 'importTariffs']);
    Route::get('/tariffs-import-progress', [TariffsController::class, 'tariffsImportProgress']);

    Route::apiResource('/service-provider-folders', ServiceProviderFoldersController::class);
});