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

//Route::get('employee-verification/{verificationCode}', [EmployeeController::class, 'verify'])->name('employeeVerify');

Route::middleware(['auth:sanctum', 'verified', 'accountStatus'])->group(function () {

    /* Checking whether business details present or not previously (if Present will be redirected to business Create function)*/
    Route::middleware(['businessCheck'])->group(function () {
        Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

        Route::prefix('business')->group(function () {
            Route::get('index', [BusinessController::class, 'index'])->name('businessIndex');
            Route::get('edit/{businessID}', [BusinessController::class, 'edit'])->name('businessEdit');
            Route::post('edit/{businessID}', [BusinessController::class, 'update']);
        });

        /* Office Routes Start */
        Route::prefix('office')->group(function () {
            Route::get('/', [OfficeController::class, 'index'])->name('officeIndex');
            Route::get('create', [OfficeController::class, 'create'])->name('officeCreate');
            Route::post('create', [OfficeController::class, 'store']);
            Route::get('edit/{officeID}', [OfficeController::class, 'edit'])->name('officeEdit');
            Route::post('edit/{officeID}', [OfficeController::class, 'update']);
            Route::get('delete/{officeID}', [OfficeController::class, 'delete'])->name('officeDelete');
        });
        /* Office Routes End */

        /* Employee Routes Start */
        Route::prefix('employee')->middleware('permission:view employee')->group(function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('employeeIndex');
            Route::get('create', [EmployeeController::class, 'create'])->name('employeeCreate');
            Route::post('create', [EmployeeController::class, 'store']);
            Route::get('edit/{userID}', [EmployeeController::class, 'edit'])->name('employeeEdit');
            Route::post('edit/{userID}', [EmployeeController::class, 'update']);
            Route::get('show/{userID}', [EmployeeController::class, 'show'])->name('employeeShow');
            Route::get('delete/{userID}', [EmployeeController::class, 'delete'])->name('employeeDelete');
            Route::post('permissions-search', [EmployeeController::class, 'permissions'])->name('permissionsSearch');
            Route::get('profile/update/', [EmployeeController::class, 'profileEdit'])->name('userProfileEdit');
            Route::post('profile/update/', [EmployeeController::class, 'profileUpdate']);
        });
        /* Employee Routes End */
    });

    /* Checking whether business details present or not previously (if Present will be redirected back) */
    Route::middleware(['businessCreateCheck'])->group(function () {
        Route::get('business-create', [BusinessController::class, 'create'])->name('businessCreate');
        Route::post('business-create', [BusinessController::class, 'store']);
    });
});
