<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class packageExpired
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse|RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse|RedirectResponse|Response
    {
        $packageExpired = auth()->user()->business->businessPackages()->where('end_date', '<', Carbon::now())->where('status', 1)->first();

        if ($request->expectsJson()) {
            if ($packageExpired)
            {
                if ($packageExpired->package_id == 9){
                    return response()->json(['error', 'Your trial package has expired please purchase a package.'], 402);
                }
                else{
                    return response()->json(['error', 'Your package has been expired please renew your package'], 402);
                }
            }
        }
        elseif (!$request->expectsJson()){
            if ($packageExpired)
            {
                if ($packageExpired->package_id == 9){
                    return to_route('package.index')->with('error', 'Your trial package has expired please purchase a package.');
                }
                else{
                    return to_route('package.index')->with('error', 'Your package has expired please renew your package.');
                }
            }
        }
        return $next($request);
    }
}
