<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class emailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('ibr')->user()->email_verified_at == null && auth()->guard('ibr')->user()->verified == 0 )
        {
            return redirect()->route('ibr.ibrEmailVerify');
        }
        return $next($request);
    }
}
