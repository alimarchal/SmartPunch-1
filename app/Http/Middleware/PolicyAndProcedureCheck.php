<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PolicyAndProcedureCheck
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse|RedirectResponse|Response|View
     */
    public function handle(Request $request, Closure $next): JsonResponse|RedirectResponse|Response|View
    {
        if (!auth()->user()->hasRole('admin') && auth()->user()->terms == 0)
        {
            if ($request->expectsJson()){
                /* 428 => Precondition Required */
                return response()->json(['error' => 'Please accept privacy policy and terms & conditions of SmartPunch to proceed'], 428);
            }
            elseif (!$request->expectsJson()){
                return redirect()->route('confirmTermsAndPolicy');
            }
        }
        return $next($request);
    }
}
