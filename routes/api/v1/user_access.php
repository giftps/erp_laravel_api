<?php

namespace App\Http\Controllers\Api\V1\UserAccess;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes that contain the various permissions that a particular 
| user has are defined.
|
*/

Route::prefix('/v1/user-access')->middleware(['auth:api', 'role:Super Admin'])->group(function(){
    Route::apiResource('/modules', ModulesController::class);
    Route::apiResource('/permissions', PermissionsController::class);
    Route::apiResource('/roles', RolesController::class);
});