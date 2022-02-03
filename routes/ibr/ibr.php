<?php

use App\Http\Controllers\ibr\IbrController;
use App\Http\Controllers\ibr\LoginController;
use App\Http\Controllers\ibr\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('ibr_authenticated')->prefix('ibr/')->name('ibr.')->group(function () {
    Route::get('search-ibr', [RegisterController::class, 'search_ibr'])->name('search_ibr');

    Route::get('register', [RegisterController::class, 'register'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('login', [LoginController::class, 'login_view'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('forgot-password', [LoginController::class, 'forgot_password_view'])->name('forgotPassword');
    Route::post('forgot-password', [LoginController::class, 'forgot_password']);
});

Route::middleware(['auth:ibr'])->prefix('ibr')->name('ibr.')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('email-verify-check/{token}', [RegisterController::class, 'email_verify_check'])->name('ibrEmailVerifyCheck');
    Route::get('email-verify', [RegisterController::class, 'email_verify'])->name('ibrEmailVerify');
    Route::post('resend-email-verify', [RegisterController::class, 'resend_email_verification'])->name('ibrResendEmailVerification');

    /* Added web users middleware inorder to prevent web guard users to use ibr guarded user routes */
    Route::middleware(['verified_email', 'web_guarded_users'])->group(function () {
            Route::get('dashboard', [IbrController::class, 'dashboard'])->name('dashboard');
            Route::get('referrals', [IbrController::class, 'referrals'])->name('referrals');
    });
});
