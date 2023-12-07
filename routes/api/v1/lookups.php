<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for predefined lookups which can be later
| be modified by the admin who has the right permissions will be added.
|
*/

Route::prefix('/v1/lookups')->middleware(['auth:api'])->group(function(){
    Route::apiResource('/auth-statuses', AuthStatusesController::class);
    Route::apiResource('/auth-types', AuthTypesController::class);
    Route::apiResource('/benefit-options', BenefitOptionsController::class);
    Route::apiResource('/cities', CitiesController::class);
    Route::apiResource('/claim-assessment-notes', ClaimAssessmentNotesController::class);
    Route::apiResource('/claim-codes', ClaimCodesController::class);
    Route::apiResource('/claim-statuses', ClaimStatusesController::class);
    Route::apiResource('/claim-types', ClaimTypesController::class);
    Route::apiResource('/countries', CountriesController::class);
    Route::apiResource('/currencies', CurrenciesController::class);
    Route::apiResource('/dependent-types', DependentTypesController::class);
    Route::apiResource('/doctor-flag-types', DoctorFlagTypesController::class);
    Route::apiResource('/exclusion-codes', ExclusionCodesController::class);
    Route::apiResource('/flag-types', FlagTypesController::class);
    Route::apiResource('/group-types', GroupTypesController::class);
    Route::apiResource('/languages', LanguagesController::class);
    Route::apiResource('/member-statuses', MemberStatusesController::class);
    Route::apiResource('/modus-operandis', ModusOperandisController::class);
    Route::apiResource('/payment-types', PaymentTypesController::class);
    Route::apiResource('/provinces', ProvincesController::class);
    Route::apiResource('/relationships', RelationshipsController::class);
    Route::apiResource('/resign-codes', ResignCodesController::class);
    Route::apiResource('/suspension-lift-reasons', SuspensionLiftReasonsController::class);
    Route::apiResource('/broker-types', BrokerTypesController::class);
    Route::apiResource('/service-codes', ServiceCodesController::class);
    Route::get('/scheme-benefit-options', [SchemeBenefitsController::class, 'index']);
    Route::post('/scheme-benefit-options', [SchemeBenefitsController::class, 'store'])->middleware('throttle:500,1');
    Route::apiResource('/scheme-subscriptions', SchemeSubscriptionsController::class)->middleware('throttle:500,1');
    Route::post('/add-update-scheme-subscription', [SchemeSubscriptionsController::class, 'addUpdateSubscription'])->middleware('throttle:500,1');
    Route::apiResource('/scheme-benefit-amounts', SchemeBenefitAmountController::class)->middleware('throttle:500,1');
    Route::apiResource('/age-groups', AgeGroupsController::class);
    Route::apiResource('/years', YearsController::class);
    Route::apiResource('/departments', DepartmentsController::class);
    Route::apiResource('/medical-history-options', MedicalHistoryOptionsController::class);
});

Route::prefix('/v1/lookups')->group(function(){
    Route::apiResource('/titles', TitlesController::class);
    Route::apiResource('/genders', GendersController::class);
    Route::apiResource('/subscription-period', SubscriptionPeriodsController::class);
    Route::apiResource('/scheme-types', SchemeTypesController::class);
    Route::apiResource('/scheme-options', SchemeOptionsController::class)->middleware('throttle:500,1');
});