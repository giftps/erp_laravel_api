<?php

namespace App\Http\Controllers\Api\V1\UsersAndAdministrations;

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

Route::prefix('/v1/users-and-administrations')->middleware(['auth:api'])->group(function(){
    Route::apiResource('/users', UsersController::class);
    Route::apiResource('/admins', AdminsController::class);
    Route::post('/activate-deactivate', [AdminsController::class, 'activateDeactivate']);
    Route::post('/reset-password', [AdminsController::class, 'expiredPasswordReset']);
});