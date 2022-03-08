<?php

use App\Http\Controllers\v1\BusinessController;
use App\Http\Controllers\v1\EmployeeController;
use App\Http\Controllers\v1\OfficerController;
use App\Http\Controllers\v1\PackageController;
use App\Http\Controllers\v1\PunchController;
use App\Http\Controllers\v1\ReportController;
use App\Http\Controllers\v1\ScheduleController;
use App\Http\Controllers\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/user/email-notification', [UserController::class, 'email_notification']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/forgot-password', [UserController::class, 'forgot_password']);

    /* Countries and cities API */
    Route::get('/countries', function (){
        return response()->json(['countries' => \App\Models\Country::all('id','name')]);
    });
    Route::get('/cities/{country_id}', function ($country_id){
        $cities = \App\Models\City::where('country_id', $country_id)->select(['id', 'name'])->get();
        return response()->json(['cities' => $cities]);
    });
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function ()
{
    Route::post('/verify', [UserController::class, 'verify_otp']);
    Route::post('/resend/otp', [UserController::class, 'resend_otp']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::middleware( 'verified')->group(function ()
    {
        // Businesses APIs
        Route::prefix('business')->group(function () {
            Route::get('/', [BusinessController::class, 'index']);
            Route::post('/', [BusinessController::class, 'store']);
            Route::put('/{id}', [BusinessController::class, 'update']);
            Route::post('/update-package', [BusinessController::class, 'packageUpdate']);
        });

        // Packages APIs
        Route::prefix('package')->group(function () {
            Route::get('/', [PackageController::class, 'index']);
        });

        // Office APIs
        Route::prefix('office')->group(function () {
            Route::get('/', [OfficerController::class, 'index']);
            Route::post('/', [OfficerController::class, 'store']);
            Route::get('/{id}', [OfficerController::class, 'show']);
            Route::put('/{id}', [OfficerController::class, 'update']);
            Route::delete('/{id}', [OfficerController::class, 'delete']);
            Route::get('/employees/{id}', [OfficerController::class, 'employees']);
        });

        /* Profile Update Routes */
        Route::post('profile/update/', [EmployeeController::class, 'profileUpdate']);
        /* Profile Update Routes */

        // Employee APIs
        Route::prefix('employee')->group(function () {
            Route::get('/', [EmployeeController::class, 'index']);
            Route::post('/', [EmployeeController::class, 'store']);
            Route::get('/show/{id}', [EmployeeController::class, 'show']);
            Route::post('/update/{id}', [EmployeeController::class, 'update']);
            Route::post('/suspend/{id}', [EmployeeController::class, 'status']);
        });

        // Punch Table APIs
        Route::get('/punch-info', [PunchController::class, 'index']);
        Route::post('/punch', [PunchController::class, 'store']);

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
        });

        // Reports
        Route::get('/report', [ReportController::class, 'user_id']);
        Route::post('user-report', [ReportController::class, 'userReport']);
        Route::post('my-report', [ReportController::class, 'index']);

        // Schedule
        Route::prefix('schedule')->group(function () {
            Route::get('/show', [ScheduleController::class, 'show']);
            Route::post('/approve/{id}', [ScheduleController::class, 'approve']);
            Route::resource('/', ScheduleController::class);
        });

    });
});
