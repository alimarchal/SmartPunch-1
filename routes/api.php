<?php

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
    Route::post('/login', [\App\Http\Controllers\v1\UserController::class, 'login']);
    Route::post('/user/email-notification', [\App\Http\Controllers\v1\UserController::class, 'email_notification']);
    Route::post('/register', [\App\Http\Controllers\v1\UserController::class, 'register']);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\v1\UserController::class, 'logout']);
    Route::post('/business', [\App\Http\Controllers\v1\BusinessController::class, 'store']);
    Route::get('/business/{id}', [\App\Http\Controllers\v1\BusinessController::class, 'show']);
    Route::put('/business/{id}', [\App\Http\Controllers\v1\BusinessController::class, 'update']);
    Route::get('/business', [\App\Http\Controllers\v1\BusinessController::class, 'index']);
    Route::delete('/business/{id}', [\App\Http\Controllers\v1\BusinessController::class, 'destroy']);

    Route::post('/office', [\App\Http\Controllers\v1\OfficerController::class, 'store']);
    Route::get('/office/{id}', [\App\Http\Controllers\v1\OfficerController::class, 'show']);
    Route::put('/office/{id}', [\App\Http\Controllers\v1\OfficerController::class, 'update']);
    Route::get('/office', [\App\Http\Controllers\v1\OfficerController::class, 'index']);
    Route::delete('/office/{id}', [\App\Http\Controllers\v1\OfficerController::class, 'destroy']);

    Route::get('/user', [\App\Http\Controllers\v1\UserController::class, 'index']);
    Route::get('/user/{id}', [\App\Http\Controllers\v1\UserController::class, 'show']);
    Route::put('/user/{id}', [\App\Http\Controllers\v1\UserController::class, 'update']);

    // Reports
    Route::get('/report', [\App\Http\Controllers\v1\ReportController::class, 'user_id']);

    // Schedule
    Route::resource('/schedule', \App\Http\Controllers\v1\ScheduleController::class);

});
