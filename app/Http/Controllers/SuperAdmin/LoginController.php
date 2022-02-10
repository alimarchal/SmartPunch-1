<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:super_admin')->except('logout');
    }

    protected function guard(): Guard|StatefulGuard
    {
        return Auth::guard('super_admin');
    }

    public function login_view(): View
    {
        return view('superAdmin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('super_admin')->attempt($credentials))
        {
            return redirect()->route('superAdmin.dashboard');
        }
        else
        {
            return redirect()->route('superAdmin.login')->withErrors('Invalid credentials')->withInput();
        }

    }

    public function logout(): RedirectResponse
    {
        \auth()->guard('super_admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('superAdmin.login');
    }
}
