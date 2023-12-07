<?php

namespace App\Http\Controllers\Api\V1\Media;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here all the routes for the sales department
|
*/

Route::prefix('/v1/media')->middleware(['auth:api', 'role:Sales Admin|Super Admin'])->group(function(){
    Route::apiResource('/all-folders', FoldersController::class);
    Route::apiResource('/files', FilesController::class);
});