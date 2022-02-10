<?php

namespace App\Http\Controllers\ibr;

use App\Http\Controllers\Controller;
use App\Mail\ibr\forgotPassword;
use App\Models\Ibr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
//    protected $redirectTo = 'ibr-dashboard';

    public function __construct()
    {
        $this->middleware('guest:ibr')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('ibr');
    }

    public function login_view()
    {
        return view('ibr.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('ibr')->attempt($credentials)) {
            return redirect()->route('ibr.dashboard');
        }
        else
        {
            return redirect()->route('ibr.login')->withErrors('Invalid credentials')->withInput();
        }

    }

    public function logout(): RedirectResponse
    {
        \auth()->guard('ibr')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('ibr.login');
    }

    public function forgot_password_view()
    {
        return view('ibr.auth.forgot-password');
    }

    public function forgot_password(Request $request)
    {

        $email = $request->only('email');

        $ibrEmail = Ibr::where('email', $email)->first();

        if (isset($ibrEmail))
        {
            $password = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9);

            Ibr::where('id', $ibrEmail->id)->update([
                'password' => Hash::make($password),
            ]);

            $ire = Ibr::where('id', $ibrEmail->id)->first();

            Mail::to($ire)->send(new forgotPassword($password));

            session()->flash('message','New password is send to your email address');
            return redirect()->route('ibr.login');
        }

        session()->flash('message', 'Invalid Email ID');
        return redirect()->back();

    }

}
