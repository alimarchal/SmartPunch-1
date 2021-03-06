<?php

use App\Http\Controllers\ibr\IbrController;
use App\Http\Controllers\ibr\LoginController;
use App\Http\Controllers\ibr\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('ibr_authenticated')->prefix('ibr/')->name('ibr.')->group(function () {
    Route::get('search-ibr', [RegisterController::class, 'search_ibr'])->name('search_ibr');

    Route::get('register', [RegisterController::class, 'register'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    Route::post('/search-cities', [RegisterController::class, 'searchCities'])->name('search-cities');
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
            Route::get('business-referrals', [IbrController::class, 'business_referrals'])->name('business_referrals');
            Route::get('ibr-referrals', [IbrController::class, 'ibr_referrals'])->name('ibr_referrals');

            /* Profile Update Routes */
            Route::get('profile/update/', [IbrController::class, 'profileEdit'])->name('userProfileEdit');
            Route::post('profile/update/', [IbrController::class, 'profileUpdate']);
    });
});
