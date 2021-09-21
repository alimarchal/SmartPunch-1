<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class BusinessCreateCheck
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
        if (auth()->user()->business()->exists() || !auth()->user()->hasPermissionTo('view business'))
        {
            return redirect()->back();
        }
        return $next($request);
    }
}
