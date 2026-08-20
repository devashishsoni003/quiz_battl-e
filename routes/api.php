<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PageApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public CMS Pages (Direct API root routes)
Route::get('/about-us', [PageApiController::class, 'aboutUs']);
Route::get('/privacy-policy', [PageApiController::class, 'privacyPolicy']);
Route::get('/terms-and-conditions', [PageApiController::class, 'termsAndConditions']);
Route::get('/pages/{slug}', [PageApiController::class, 'getPage']);

Route::middleware(\App\Http\Middleware\VerifyApiKey::class)->group(function () {
    Route::post('/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
});

Route::prefix('v1')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::middleware(\App\Http\Middleware\VerifyApiKey::class)->group(function () {
        Route::post('/send-otp', [AuthController::class, 'sendOtp']);
        Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    });
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/categories', [\App\Http\Controllers\Api\CategoryApiController::class, 'index']);
    Route::post('/quiz-levels', [\App\Http\Controllers\Api\QuizLevelApiController::class, 'index']);
    Route::get('/help-support', [\App\Http\Controllers\Api\HelpSupportApiController::class, 'index']);

    Route::get('/about-us', [PageApiController::class, 'aboutUs']);
    Route::get('/privacy-policy', [PageApiController::class, 'privacyPolicy']);
    Route::get('/terms-and-conditions', [PageApiController::class, 'termsAndConditions']);
    Route::get('/pages/{slug}', [PageApiController::class, 'getPage']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [UserController::class, 'getProfile']);
        Route::post('/update-profile', [UserController::class, 'updateProfile']);
        Route::post('/change-password', [UserController::class, 'changePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/logout-all-devices', [AuthController::class, 'logoutAll']);

        Route::get('/referral', [\App\Http\Controllers\Api\ReferralApiController::class, 'getReferralData']);
        Route::get('/referral/history', [\App\Http\Controllers\Api\ReferralApiController::class, 'getHistory']);
        Route::post('/referral/apply', [\App\Http\Controllers\Api\ReferralApiController::class, 'applyReferral']);
        Route::get('/referral/share', [\App\Http\Controllers\Api\ReferralApiController::class, 'getShareData']);
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
