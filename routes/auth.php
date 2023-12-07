<?php

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\AuthenticationsController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthenticationsController::class, 'register'])
                ->name('register');

Route::post('/login', [AuthenticationsController::class, 'login'])
                ->name('login');

// Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                 ->middleware('guest')
//                 ->name('password.email');
