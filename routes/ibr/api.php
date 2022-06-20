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

    /* Currencies API */
    Route::get('/currencies', function (){
        return response()->json(['currencies' => DB::table('currencies')->get()]);
    });
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

        /* Bank Details API */
        Route::get('bank-details', [IbrController::class, 'bank_details']);
        Route::post('bank-detail-update', [IbrController::class, 'update_bank_details']);
        /* Bank Details API */

        /* Profile Update API */
        Route::post('profile/update/', [IbrController::class, 'profileUpdate']);
        /* Profile Update API */

        /* Direct Commission API */
        Route::get('direct-commissions', [IbrController::class, 'directCommissions']);
        /* Direct Commission Routes */

        /* Indirect Commission API */
        Route::get('indirect-commissions', [IbrController::class, 'inDirectCommissions']);
        /* Indirect Commission Routes */

        /* Dashboard related APIs start */

        /* My earnings API */
        Route::get('earnings', [IbrController::class, 'myEarnings']);
        /* My earnings API */

        /* My clients API */
        Route::get('clients', [IbrController::class, 'myClients']);
        /* My clients API */

        /* My network API */
        Route::get('network', [IbrController::class, 'myNetworks']);
        /* My network API */

        /* Dashboard related APIs end */
    });
});
