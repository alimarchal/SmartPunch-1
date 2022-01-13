<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
})->name('home');

//Route::get('/config-clear', function() {
//    Artisan::call('config:clear');
//    Artisan::call('optimize:clear');
//    Artisan::call('vendor:publish --tag=graphql-playground-config');
//    Artisan::call('vendor:publish --tag=graphql-playground-view');
//    Artisan::call('vendor:publish --tag=graphql-playground-config');
//    // Do whatever you want either a print a message or exit
//});

Route::middleware(['auth:sanctum', 'verified', 'accountStatus'])->group(function () {

    /* Checking whether business details present or not previously (if Present will be redirected to business Create function)*/
    Route::middleware(['businessCheck'])->group(function () {
        Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

        /* Business Routes Start */
        Route::prefix('business')->group(function () {
            Route::get('index', [BusinessController::class, 'index'])->name('businessIndex');
            Route::get('edit/{businessID}', [BusinessController::class, 'edit'])->name('businessEdit');
            Route::post('edit/{businessID}', [BusinessController::class, 'update']);

            Route::middleware('permission:suspend business')->group(function (){
                /* Function for admin to retrieve all businesses  */
                Route::get('all', [BusinessController::class, 'allBusinesses'])->name('businesses');
                /* Function for admin to retrieve all offices of a business  */
                Route::get('offices/{officeID}', [BusinessController::class, 'businessOffices'])->name('businessOffices');
                /* Function for admin to retrieve all employees of an office  */
                Route::get('offices/employees/{officeID}', [BusinessController::class, 'businessOfficesEmployees'])->name('listOfBusinessOfficesEmployees');
            });
        });

        /* Office Routes Start */
        Route::prefix('office')->middleware('permission:view office')->group(function () {
            Route::get('/', [OfficeController::class, 'index'])->name('officeIndex');
            Route::get('create', [OfficeController::class, 'create'])->name('officeCreate')->middleware('permission:create office');
            Route::post('create', [OfficeController::class, 'store']);
            Route::get('edit/{officeID}', [OfficeController::class, 'edit'])->name('officeEdit');
            Route::post('edit/{officeID}', [OfficeController::class, 'update']);
            Route::get('delete/{officeID}', [OfficeController::class, 'delete'])->name('officeDelete');
            Route::get('employees/{officeID}', [OfficeController::class, 'employees'])->name('listOfEmployees');
            Route::post('/get-schedules', [OfficeController::class, 'schedules'])->name('getSchedules');
        });
        /* Office Routes End */

        /* Employee Routes Start */
        Route::prefix('employee')->middleware('permission:view employee')->group(function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('employeeIndex');
            Route::get('create', [EmployeeController::class, 'create'])->name('employeeCreate');
            Route::post('create', [EmployeeController::class, 'store']);
            Route::get('edit/{userID}', [EmployeeController::class, 'edit'])->name('employeeEdit')->middleware('permission:update employee');
            Route::post('edit/{userID}', [EmployeeController::class, 'update']);
            Route::get('show/{userID}', [EmployeeController::class, 'show'])->name('employeeShow');
            Route::get('delete/{userID}', [EmployeeController::class, 'delete'])->name('employeeDelete');
            Route::post('permissions-search', [EmployeeController::class, 'permissions'])->name('permissionsSearch');
            Route::get('profile/update/', [EmployeeController::class, 'profileEdit'])->name('userProfileEdit');
            Route::post('profile/update/', [EmployeeController::class, 'profileUpdate']);
        });
        /* Employee Routes End */

        /* Schedule Routes Start */
        Route::prefix('schedule')->middleware('permission:view schedule')->group(function () {
            Route::get('show/', [ScheduleController::class, 'show'])->name('scheduleShow');
            Route::middleware('permission:create schedule')->group(function () {
                Route::get('/', [ScheduleController::class, 'index'])->name('scheduleIndex');
                Route::get('create', [ScheduleController::class, 'create'])->name('scheduleCreate');
                Route::post('create', [ScheduleController::class, 'store']);
                Route::get('edit/{userID}', [ScheduleController::class, 'edit'])->name('scheduleEdit')->middleware('permission:update schedule');
                Route::post('edit/{userID}', [ScheduleController::class, 'update']);
                Route::get('delete/{userID}', [ScheduleController::class, 'delete'])->name('scheduleDelete');
                Route::post('approve/status', [ScheduleController::class, 'approve'])->name('scheduleApprove');
            });
        });
        /* Schedule Routes End */
    });

    /* Checking whether business details present or not previously (if Present will be redirected back) */
    Route::middleware(['businessCreateCheck'])->group(function () {
        Route::get('business-create', [BusinessController::class, 'create'])->name('businessCreate');
        Route::post('business-create', [BusinessController::class, 'store']);
    });

// Report
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
});
