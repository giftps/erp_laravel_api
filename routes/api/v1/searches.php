<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All the routes to search specific things across the system
|
*/

Route::prefix('/v1')->middleware(['auth:api', 'role:Sales Admin|Super Admin|Broker'])->group(function(){
    Route::get('/member-search/{search}', [SearchesController::class, 'members']);
    Route::get('/service-provider-search/{search}', [SearchesController::class, 'serviceProviders']);
    Route::get('/search-provider-services', [SearchesController::class, 'providerServices']);
});