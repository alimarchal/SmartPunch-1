<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Models\User;
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
    $packages = \App\Models\Package::get()->take(8);
    return view('welcome', compact('packages'));
})->name('home');
/*
Route::get('/config-clear', function() {
    Artisan::call('config:clear');
    Artisan::call('optimize:clear');
    Artisan::call('vendor:publish --tag=graphql-playground-config');
    Artisan::call('vendor:publish --tag=graphql-playground-view');
    Artisan::call('vendor:publish --tag=graphql-playground-config');
    // Do whatever you want either a print a message or exit
});
*/
Route::middleware(['auth:sanctum', 'verified', 'accountStatus'])->group(function () {

    /* Checking whether business details present or not previously (if Present will be redirected back) */
    Route::middleware(['businessCreateCheck'])->group(function () {
        Route::get('business-create', [BusinessController::class, 'create'])->name('businessCreate');
        Route::post('business-create', [BusinessController::class, 'store']);
    });

    Route::prefix('package')->middleware('permission:view business')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('package.index');
    });

    /* Checking whether business details present or not previously (if Present will be redirected to business Create function)*/
    Route::middleware(['businessCheck', 'package_expired'])->group(function () {
        Route::get('/dashboard', function () {
            $employees = collect();
            if (\auth()->user()->user_role == 2) /* 2 => Admin */
            {
                $employees = User::where('business_id', auth()->user()->business_id)->orderByDesc('created_at')->get()->except([auth()->id()]);
            }
            if (\auth()->user()->user_role == 3) /* 3 => Manager */
            {
                $employees = User::where('business_id', auth()->user()->business_id)->where('user_role', '!=', 2)->orderByDesc('created_at')->get()->except([auth()->id()]);
            }
            if (\auth()->user()->user_role == 4) /* 4 => Supervisor */
            {
                $userRoles = [2,3];
                $employees = User::where('business_id', auth()->user()->business_id)->whereNotIn('user_role', $userRoles)->orderByDesc('created_at')->get()->except([auth()->id()]);
            }
            return view('dashboard', compact('employees'));
        })->name('dashboard');

        /* Business Routes Start */
        Route::prefix('business')->group(function () {
            Route::get('/', [BusinessController::class, 'index'])->name('businessIndex');
            Route::get('edit/{businessID}', [BusinessController::class, 'edit'])->name('businessEdit');
            Route::post('edit/{businessID}', [BusinessController::class, 'update']);
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
        });
        /* Employee Routes End */

        /* Profile Update Routes */
        Route::get('profile/update/', [EmployeeController::class, 'profileEdit'])->name('userProfileEdit');
        Route::post('profile/update/', [EmployeeController::class, 'profileUpdate']);
        /* Profile Update Routes */

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

        // Report
        Route::prefix('reports')->middleware('permission:view reports')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('report.index');
            Route::get('/by-office', [ReportController::class, 'byOfficeView'])->name('byOffice');
            Route::post('/by-office-id', [ReportController::class, 'byOfficeID'])->name('byOfficeID');
            Route::get('/by-employee', [ReportController::class, 'byEmployeeBusinessIDView'])->name('byEmployeeBusiness');
            Route::post('/by-employee-id', [ReportController::class, 'byEmployeeBusinessID'])->name('byEmployeeBusinessID');
            Route::get('/by-employee-id-show/{id}', [ReportController::class, 'byEmployeeBusinessIDShow'])->name('byEmployeeBusinessIDShow');
            Route::get('/by-team', [ReportController::class, 'reportByTeam'])->name('reportByTeam');
        });
    });

    Route::get('teamViewShow', [\App\Http\Controllers\TeamViewController::class, 'show'])->name('teamView.show');
});
