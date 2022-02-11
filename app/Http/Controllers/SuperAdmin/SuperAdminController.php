<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SuperAdminController extends Controller
{
    public function dashboard(): View
    {
        return view('superAdmin.dashboard');
    }

    public function profileEdit(): Factory|View|Application
    {
        return view('superAdmin.credentials.edit');
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        Validator::make($request->all(),[
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
        ])->validate();

        if ($request->current_password != ''){
            if (!(Hash::check($request->get('current_password'), Auth::guard('super_admin')->user()->getAuthPassword())))
            {
                return redirect()->back()->with('error', 'Current password not matched');
            }
        }
        if ($request->password != ''){
            if (strcmp($request->get('current_password'),$request->get('password'))==0)
            {
                return redirect()->back()->with('error', 'Your current password cannot be same to new password');
            }
        }

        SuperAdmin::where('id', auth()->guard('super_admin')->id())->update(['password' => Hash::make($request->password)]);
        return redirect()->route('superAdmin.dashboard')->with('success', __('portal.Profile updated successfully!!'));

    }
}
