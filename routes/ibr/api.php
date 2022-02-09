<?php

use App\Http\Controllers\v1\BusinessController;
use App\Http\Controllers\v1\EmployeeController;
use App\Http\Controllers\v1\ibr\IbrController;
use App\Http\Controllers\v1\ibr\LoginController;
use App\Http\Controllers\v1\ibr\RegisterController;
use App\Http\Controllers\v1\OfficerController;
use App\Http\Controllers\v1\PunchController;
use App\Http\Controllers\v1\ReportController;
use App\Http\Controllers\v1\ScheduleController;
use App\Http\Controllers\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| IBR API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1/ibr')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/forgot-password', [RegisterController::class, 'forgot_password']);
});

Route::prefix('v1/ibr')->middleware(['auth:ibr_api'])->group(function ()
{
    Route::post('/verify', [LoginController::class, 'verify_otp']);
    Route::post('/resend/otp', [LoginController::class, 'resend_otp']);
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::middleware( 'email_verified')->group(function ()
    {
        Route::get('business-referrals', [IbrController::class, 'business_referrals']);
        Route::get('ibr-referrals', [IbrController::class, 'ibr_referrals']);

    });
});
