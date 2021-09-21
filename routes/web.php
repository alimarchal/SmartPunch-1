<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OfficeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified',])->group(function () {

    /* Checking whether business details present or not previously (if Present will be redirected to business Create function)*/
    Route::middleware(['businessCheck'])->group(function () {
        Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');;
        Route::get('business', [BusinessController::class, 'index'])->name('businessIndex');

        /* Office Routes Start */
        Route::get('offices', [OfficeController::class, 'index'])->name('officeIndex');
        Route::get('office-create', [OfficeController::class, 'create'])->name('officeCreate');
        Route::post('office-create', [OfficeController::class, 'store']);
        /* Office Routes End */

        /* Employee Routes Start */
        Route::middleware('permission:view employee')->group(function () {
            Route::get('employees', [EmployeeController::class, 'index'])->name('employeeIndex');
            Route::get('employee-create', [EmployeeController::class, 'create'])->name('employeeCreate');
            Route::post('employee-create', [EmployeeController::class, 'store']);
        });
        /* Employee Routes End */
    });

    /* Checking whether business details present or not previously (if Present will be redirected back) */
    Route::middleware(['businessCreateCheck'])->group(function () {
        Route::get('business-create', [BusinessController::class, 'create'])->name('businessCreate');
        Route::post('business-create', [BusinessController::class, 'store']);
    });
});
