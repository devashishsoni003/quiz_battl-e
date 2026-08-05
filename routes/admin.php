<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest:super_admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Authenticated Routes
Route::middleware('auth:super_admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // My Profile Routes
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [DashboardController::class, 'changePassword'])->name('profile.change_password');

    // Home Management
    // Home Sliders
    Route::resource('home-sliders', \App\Http\Controllers\Admin\HomeSliderController::class)->except(['show']);
    Route::post('home-sliders/{home_slider}/toggle-status', [\App\Http\Controllers\Admin\HomeSliderController::class, 'toggleStatus'])->name('home-sliders.toggle-status');

    // Home Promotions
    Route::resource('home-promotions', \App\Http\Controllers\Admin\HomePromotionController::class)->except(['show']);
    Route::post('home-promotions/{home_promotion}/toggle-status', [\App\Http\Controllers\Admin\HomePromotionController::class, 'toggleStatus'])->name('home-promotions.toggle-status');

    // Content Management
    // Categories
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
    Route::post('categories/{category}/toggle-status', [\App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Quiz Management
    // Quiz Levels
    Route::resource('quiz-levels', \App\Http\Controllers\Admin\QuizLevelController::class)->except(['show']);
    Route::post('quiz-levels/{quiz_level}/toggle-status', [\App\Http\Controllers\Admin\QuizLevelController::class, 'toggleStatus'])->name('quiz-levels.toggle-status');

    // Customization
    // Frames
    Route::resource('frames', \App\Http\Controllers\Admin\FrameController::class)->except(['show']);
    Route::post('frames/{frame}/toggle-status', [\App\Http\Controllers\Admin\FrameController::class, 'toggleStatus'])->name('frames.toggle-status');

    // CMS
    // Pages
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->except(['show']);
    Route::post('pages/{page}/toggle-status', [\App\Http\Controllers\Admin\PageController::class, 'toggleStatus'])->name('pages.toggle-status');

    // Marketing
    // Referral Management
    Route::get('referral-settings', [\App\Http\Controllers\Admin\ReferralSettingController::class, 'edit'])->name('referral-settings.edit');
    Route::put('referral-settings', [\App\Http\Controllers\Admin\ReferralSettingController::class, 'update'])->name('referral-settings.update');
    Route::get('referrals', [\App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('referrals.index');

    // Finance
    // Withdrawal Settings
    Route::get('withdrawal-settings', [\App\Http\Controllers\Admin\WithdrawalSettingController::class, 'edit'])->name('withdrawal-settings.edit');
    Route::put('withdrawal-settings', [\App\Http\Controllers\Admin\WithdrawalSettingController::class, 'update'])->name('withdrawal-settings.update');
    // Withdrawal Requests
    Route::get('withdrawal-requests', [\App\Http\Controllers\Admin\WithdrawalRequestController::class, 'index'])->name('withdrawal-requests.index');
    Route::post('withdrawal-requests/{id}/approve', [\App\Http\Controllers\Admin\WithdrawalRequestController::class, 'approve'])->name('withdrawal-requests.approve');
    Route::post('withdrawal-requests/{id}/reject', [\App\Http\Controllers\Admin\WithdrawalRequestController::class, 'reject'])->name('withdrawal-requests.reject');
});
