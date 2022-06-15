<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class locale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        App::setLocale(auth()->user()->language);
        session()->put('locale', auth()->user()->language);
        if (auth()->user()->language == 'ur' || auth()->user()->language == 'ar' || auth()->user()->language == 'fa'){
            auth()->user()->update(['rtl' => 1]);
        }else{
            auth()->user()->update(['rtl' => 0]);
        }
        return $next($request);
    }
}