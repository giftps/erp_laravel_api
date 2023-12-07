<?php

namespace App\Http\Controllers\Api\V1\NonStaffUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Membership\MembersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the non staff that are authenticated. These include brokers, broker houses, members and service providers
|
*/

// Member completing registration via registration token

// Group of routes for the broker house
Route::prefix('/v1/broker-house')->middleware(['auth:api', 'role:Broker House Admin'])->group(function(){
    Route::get('details', [BrokerHousesController::class, 'brokerHouseDetails']);
    Route::post('edit', [BrokerHousesController::class, 'editBrokerHouse']);
    Route::post('brokers', [BrokerHousesController::class, 'addBroker']);
    Route::put('brokers/{id}', [BrokerHousesController::class, 'updateBroker']);
    Route::get('brokers', [BrokerHousesController::class, 'brokers']);
    Route::get('brokers/{id}', [BrokerHousesController::class, 'brokerDetails']);
    Route::get('brokers/{id}/members', [BrokerHousesController::class, 'brokerMembers']);
    Route::get('members', [BrokerHousesController::class, 'brokerHouseMembers']);
});

// Group of routes for the broker
Route::prefix('/v1/broker')->middleware(['auth:api', 'role:Broker|Sales Admin|Super Admin'])->group(function(){
    Route::get('details', [BrokersController::class, 'brokerDetails']);
    Route::get('members', [BrokersController::class, 'members']);
    Route::post('edit', [BrokersController::class, 'editBroker']);
});

// Generating a quotation
Route::post('/v1/broker/add-member', [BrokersController::class, 'addMembers'])->middleware(['auth:api', 'role:Broker|Membership Admin|Sales Admin|Super Admin']);

Route::prefix('/v1/broker')->middleware(['auth:api', 'role:Broker|Broker House Admin|Sales Admin|Super Admin'])->group(function(){
    Route::get('member/{id}', [MembersController::class, 'show']);
    Route::put('member/{id}', [BrokersController::class, 'updateMember']);
});

Route::prefix('/v1/member/{register_token}')->group(function(){
    Route::get('member/{id}', [MembersController::class, 'memberByToken']);
    Route::get('check-register-token-validity', [NonStaffMembersController::class, 'tokenValidity']);
    Route::post('accept-or-reject-quotation', [NonStaffMembersController::class, 'acceptOrRejectQuotation']);
    Route::get('show-details', [NonStaffMembersController::class, 'showDetails']);
    Route::post('complete-member-registration', [NonStaffMembersController::class, 'completeRegistration']);
    Route::post('family-members-medical-history', [NonStaffMembersController::class, 'familyMembersMedicalHistory']);
    Route::get('member-medical-history/{member_id}', [NonStaffMembersController::class, 'memberMedicalHistory']);
    Route::get('member-medical-history-options/{member_id}', [NonStaffMembersController::class, 'memberMedicalHistoryOptions']);
    Route::post('digital-signature', [NonStaffMembersController::class, 'storeDigitalSignature']);
    Route::post('accept-or-reject-underwriting', [NonStaffMembersController::class, 'acceptOrRejectUnderwriting']);
    Route::post('accept-or-reject-invoice', [NonStaffMembersController::class, 'acceptOrRejectInvoice']);
    Route::post('set-registration-as-complete', [NonStaffMembersController::class, 'makeRegistrationAsComplete']);
}); 