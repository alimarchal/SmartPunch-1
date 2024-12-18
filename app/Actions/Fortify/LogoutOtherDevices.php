<?php

namespace App\Actions\Fortify;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutOtherDevices extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        // logout other devices
        Auth::logoutOtherDevices($request->password);
        \auth()->user()->tokens()->delete();
        return $next($request);
    }
}
