<?php

namespace App\Http\Middleware;

use App\Models\Business;
use Closure;
use Illuminate\Http\Request;

class BusinessCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Business::where('user_id', auth()->id())->first() && auth()->user()->hasPermissionTo('view business') && auth()->user()->user_role != 1)
        {
            return redirect()->route('businessCreate');
        }

        return $next($request);
    }
}
