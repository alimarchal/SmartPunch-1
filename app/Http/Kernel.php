<?php

namespace App\Http;

use App\Http\Middleware\AccountStatus;
use App\Http\Middleware\api_verfied_email;
use App\Http\Middleware\BusinessCheck;
use App\Http\Middleware\BusinessCreateCheck;
use App\Http\Middleware\emailVerified;
use App\Http\Middleware\ibrAuthenticated;
use App\Http\Middleware\IbrUsers;
use App\Http\Middleware\locale;
use App\Http\Middleware\PackageExpired;
use App\Http\Middleware\SuperAdmin;
use App\Http\Middleware\webUsers;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Spatie\Permission\Middlewares\PermissionMiddleware;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Laravel\Jetstream\Http\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            /* Below middleware used for saving only session locale */
//            \App\Http\Middleware\Localization::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'businessCheck' => BusinessCheck::class,
        'businessCreateCheck' => BusinessCreateCheck::class,
        'accountStatus' => AccountStatus::class,
        'verified_email' => emailVerified::class,
        'ibr_authenticated' => ibrAuthenticated::class,
        'web_guarded_users' => webUsers::class,
        'email_verified' => api_verfied_email::class,
        'package_expired' => packageExpired::class,
        'permission' => PermissionMiddleware::class,
        'locale' => locale::class,
    ];
}
