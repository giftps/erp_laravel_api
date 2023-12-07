<?php

namespace App\Http\Controllers\Api\V1\Preauthorisations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes that have to do with preauthorisations are here.
|
*/

Route::prefix('/v1')->middleware(['auth:api', 'role:Super Admin|Call Center Admin'])->group(function(){
    Route::apiResource('/preauthorisations', PreauthorisationsController::class);
    Route::post('/services-payment-details', [PreauthorisationsController::class, 'paymentDetails']);
    Route::get('/member-case-numbers', [PreauthorisationsController::class, 'memberCaseNumbersWithProvider']);
    Route::get('/last-few-preauthorisations/{member_id}', [PreauthorisationsController::class, 'limitedMemberPreauthorisations']);
    Route::get('/preauthorisation-by-authcode/{auth_code}', [PreauthorisationsController::class, 'getPreauthByAuthNumber']);
    Route::put('/close-preauth/{id}', [PreauthorisationsController::class, 'closePreauth']);
});