<?php

namespace App\Http\Controllers\Api\V1\Claims;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Api\V1\UserAccess\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for predefined lookups which can be later
| be modified by the admin who has the right permissions will be added.
|
*/

Route::prefix('/v1')->middleware(['auth:api', 'role:Claims Admin|Super Admin'])->group(function(){
    Route::apiResource('/claims-log', ClaimsLogsController::class);
    Route::apiResource('/batch-allocations', BatchAllocationsController::class);
    Route::apiResource('/claims', ClaimsController::class);
    Route::apiResource('/assessors', AssessorsController::class);
    Route::get('/assessor-batches', [ClaimsLogsController::class, 'assessorBatches']);
});