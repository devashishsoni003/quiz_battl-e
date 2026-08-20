<?php

use App\Http\Controllers\Seller\AuthController;
use App\Http\Controllers\Seller\DashboardController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest:seller')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send-otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');
});

// Authenticated Routes
Route::middleware('auth:seller')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Coins Transfer and History
    Route::get('/transfer', [\App\Http\Controllers\Seller\TransactionController::class, 'showTransferForm'])->name('transfer');
    Route::get('/users/search', [\App\Http\Controllers\Seller\TransactionController::class, 'searchUser'])->name('users.search');
    Route::post('/transfer', [\App\Http\Controllers\Seller\TransactionController::class, 'transferCoins'])->name('transfer.submit');
    
    Route::get('/transactions', [\App\Http\Controllers\Seller\TransactionController::class, 'transactionsList'])->name('transactions');
    Route::get('/distributions', [\App\Http\Controllers\Seller\TransactionController::class, 'distributionsList'])->name('distributions');
});
