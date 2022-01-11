<?php

use App\Http\Controllers\v1\BusinessController;
use App\Http\Controllers\v1\EmployeeController;
use App\Http\Controllers\v1\OfficerController;
use App\Http\Controllers\v1\PunchController;
use App\Http\Controllers\v1\ReportController;
use App\Http\Controllers\v1\ScheduleController;
use App\Http\Controllers\v1\ScheduleTypeController;
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

    Route::get('/punchIn', [ReportController::class, 'user_id']);
    Route::get('/punchOut', [ReportController::class, 'user_id']);
});

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function ()
{
    Route::post('/verify/{userID}/', [UserController::class, 'verify_otp']);
    Route::prefix('v1')->middleware(['auth:sanctum', 'verified'])->group(function ()
    {
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/business', [BusinessController::class, 'store']);
        Route::get('/business/{id}', [BusinessController::class, 'show']);
        Route::put('/business/{id}', [BusinessController::class, 'update']);
        Route::get('/business', [BusinessController::class, 'index']);
        Route::delete('/business/{id}', [BusinessController::class, 'destroy']);

        // Office APIs
        Route::post('/office', [OfficerController::class, 'store']);
        Route::get('/office/{id}', [OfficerController::class, 'show']);
        Route::put('/office/{id}', [OfficerController::class, 'update']);
        Route::get('/office', [OfficerController::class, 'index']);
        Route::delete('/office/{id}', [OfficerController::class, 'destroy']);

        // Employee APIs
        Route::post('/employee', [EmployeeController::class, 'store']);
        Route::post('/employee/{id}', [EmployeeController::class, 'status']);

        // Punch Table APIs
        Route::get('/punch-info', [PunchController::class, 'index']);
        Route::post('/punch', [PunchController::class, 'store']);

        Route::get('/user', [UserController::class, 'index']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::put('/user/{id}', [UserController::class, 'update']);

        // Reports
        Route::get('/report', [ReportController::class, 'user_id']);

        // Schedule
        Route::get('/schedule/office', [ScheduleController::class, 'schedules']);
        Route::resource('/schedule', ScheduleController::class);

        // Schedule Type
        Route::resource('/schedule-type', ScheduleTypeController::class);
    });
});
