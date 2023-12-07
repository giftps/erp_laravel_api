<?php

namespace App\Http\Controllers\Api\V1\AppMember;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Lookups\AuthTypesController;

use App\Http\Controllers\Api\V1\Membership\MembersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for when the member logs in
|
*/

Route::post('/v1/app-members/sending-confirmation-code', [AppMembersController::class, 'sendConfirmationCode']);
Route::post('/v1/app-members/is-correct-code', [AppMembersController::class, 'isCorrectCode']);

Route::prefix('/v1/app-members')->middleware(['auth:member'])->group(function(){
    Route::get('/member', [AppMembersController::class, 'authMember']);
    Route::get('/dependants', [AppMembersController::class, 'authMemberDependants']);
    Route::get('/documents', [AppMembersController::class, 'authMemberDocuments']);
    Route::get('/preauthorisations', [AppMembersController::class, 'authMemberPreauthorisations']);
    Route::get('/benefit-limits', [AppMembersController::class, 'authMemberBenefitLimits']);
    Route::get('/scheme-service-providers', [AppMembersController::class, 'schemeServiceProviders']);
    Route::post('/contact-support', [AppMembersController::class, 'contactSupport']);
    Route::get('/member-auth-types', [AuthTypesController::class, 'index']);
});