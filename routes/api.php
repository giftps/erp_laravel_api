<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Http\Resources\UsersResource;
use App\Http\Controllers\Api\V1\ExchangeRatesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->get('/v1/user', function (Request $request) {
    return response()->json(new UsersResource(User::with(['role'])->find($request->user()->user_id)));
});

// Authentication Routes
Route::post('/login', [AuthenticationsController::class, 'login'])->name('user.login');
Route::post('/member-login-otp', [AuthenticationsController::class, 'memberLoginOtp']);
Route::post('/member-login', [AuthenticationsController::class, 'memberLogin']);
Route::post('/generate-otp', [AuthenticationsController::class, 'generateOtp']);
Route::post('/register', [AuthenticationsController::class, 'register']);

// Forgot password and resetting process
Route::post('/forgot-password', [AuthenticationsController::class, 'forgotPassword']);
Route::post('/forgot-password-reset', [AuthenticationsController::class, 'forgotPasswordReset']);
Route::get('/check-token/{token}', [AuthenticationsController::class, 'checkToken']);
Route::post('/verify-email', [AuthenticationsController::class, 'verifyEmail']);

Route::post('/v1/resend-password', [AuthenticationsController::class, 'brokerBrokerHousePasswordReset']);

Route::get('/v1/auth-check', [AuthenticationsController::class, 'authCheck'])->middleware(['auth:api']);


// Users Routes
// Route::apiResource('/users', UsersController::class)->middleware(['auth:api']);

// Call logs
// Route::apiResource('/call-log', CallLogsController::class);

// Getting the exchange rates
Route::get('/v1/current-exchange-rate', [ExchangeRatesController::class, 'currentExchangeRate']); 
Route::get('/v1/historic-exchange-rate', [ExchangeRatesController::class, 'getHistoricExchangeRate']);