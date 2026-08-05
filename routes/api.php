<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Home Route

// API V1 Routes
Route::prefix('v1')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::middleware(\App\Http\Middleware\VerifyApiKey::class)->group(function () {
        Route::post('/send-otp', [AuthController::class, 'sendOtp']);
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    });
    Route::get('/users', [UserController::class, 'index']);

    // Protected Routes (Requires Bearer Token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [UserController::class, 'getProfile']);
        Route::post('/update-profile', [UserController::class, 'updateProfile']);
        Route::post('/logout', [AuthController::class, 'logout']);

        // Referral API
        Route::get('/referral', [\App\Http\Controllers\Api\ReferralApiController::class, 'getReferralData']);
        Route::get('/referral/history', [\App\Http\Controllers\Api\ReferralApiController::class, 'getHistory']);
        Route::post('/referral/apply', [\App\Http\Controllers\Api\ReferralApiController::class, 'applyReferral']);
        Route::get('/referral/share', [\App\Http\Controllers\Api\ReferralApiController::class, 'getShareData']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
