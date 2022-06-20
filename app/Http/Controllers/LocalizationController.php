<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function index($locale): RedirectResponse
    {
        App::setLocale($locale);
        auth()->user()->update(['language' => $locale]);
        //storing the locale in session to get it back in the middleware
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
