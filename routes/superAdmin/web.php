<?php

use App\Http\Controllers\SuperAdmin\BusinessController;
use App\Http\Controllers\SuperAdmin\LoginController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use Illuminate\Support\Facades\Route;

Route::prefix('super-admin/')->name('superAdmin.')->group(function () {
    Route::get('login', [LoginController::class, 'login_view'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware(['auth:super_admin'])->prefix('super-admin')->name('superAdmin.')->group(function () {

    Route::get('dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    /* Profile Update Routes */
    Route::get('profile/update/', [SuperAdminController::class, 'profileEdit'])->name('userProfileEdit');
    Route::post('profile/update/', [SuperAdminController::class, 'profileUpdate']);

    Route::middleware('permission:suspend business')->group(function (){
        /* Function for admin to retrieve all businesses  */
        Route::get('businesses', [BusinessController::class, 'allBusinesses'])->name('businesses');
        /* Function for admin to retrieve all offices of a business  */
        Route::get('offices/{officeID}', [BusinessController::class, 'businessOffices'])->name('businessOffices');
        /* Function for admin to retrieve all employees of an office  */
        Route::get('offices/employees/{officeID}', [BusinessController::class, 'businessOfficesEmployees'])->name('listOfBusinessOfficesEmployees');
    });
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
