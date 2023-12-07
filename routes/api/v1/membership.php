<?php

namespace App\Http\Controllers\Api\V1\Membership;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for the membership
|
*/

Route::prefix('/v1/membership')->middleware(['auth:api', 'role:Broker|Membership Admin|Super Admin|Underwriter'])->group(function(){
    // Medicals Routes
    Route::get('/medical-history-options', [MedicalsController::class, 'getAllMedicalOptions']);
    Route::post('/save-medical-history', [MedicalsController::class, 'storeMemberMedicalCondition']);

    Route::apiResource('/family', FamiliesController::class);
    Route::put('/update-common-family/{id}', [FamiliesController::class, 'updateFamilyCommonInfo']);

    Route::apiResource('/members', MembersController::class);

    Route::get('/member-activities/{member_id}', [MemberActivitiesController::class, 'memberActivities']);

    Route::post('/import-members', [MembersController::class, 'importMembers']);
    Route::get('/member-benefit-limits/{member_id}', [MembersController::class, 'memberBenefitLimits']);
    Route::get('/member-benefit-years/{member_id}', [MembersController::class, 'memberBenefitYears']);
    Route::apiResource('/documents', MemberDocumentsController::class);
    Route::apiResource('/member-medicals', MemberMedicalsController::class);
    Route::apiResource('/exclusions', ExclusionsController::class);
    Route::post('/exclusions/lift', [ExclusionsController::class, 'liftExclusion']);

    // Member Preauthorisations
    Route::get('/preauthorisations/{member_id}', [MembersController::class, 'memberPreauthorisations']);

    // Groups
    Route::apiResource('/groups', GroupsController::class);
    Route::post('/import-groups', [GroupsController::class, 'importGroups']);

    // Member folders
    Route::apiResource('/folders', MemberFoldersController::class);

    // Membership form
    Route::get('/membership-form/{member_id}', [FamiliesController::class, 'membershipForm']);

    // Member Preauths
    Route::get('/member-preauths/{member_id}', [MembersController::class, 'memberPreauths']);

    // Changing family status
    Route::put('/change-family-status/{id}', [FamiliesController::class, 'changeFamilyStatus']);

    // Resigning a member
    Route::put('/resign-member/{id}', [MembersController::class, 'resignMember']);
});

Route::get('/v1/membership/check-existence/{value}', [MembersController::class, 'checkMemberExistence'])->middleware(['auth:api']);

Route::prefix('/v1/membership')->middleware(['auth:api', 'role:Underwriter|Super Admin'])->group(function(){
    Route::post('/underwrite', [ExclusionsController::class, 'underWrite']);
});