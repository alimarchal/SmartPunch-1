<?php

namespace App\Http\Controllers\ibr;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Ibr;
use App\Models\IbrDirectCommission;
use App\Models\IbrIndirectCommission;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class IbrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:ibr');
    }

    public function dashboard(): Factory|View|Application
    {
//dd(Carbon::now()->startOfMonth()->subMonthsWithNoOverflow(3));
        $ibr_direct_com = IbrDirectCommission::select("ibr_no",
            DB::raw("(sum(amount)) as total"),
            DB::raw("(DATE_FORMAT(created_at, '%b-%Y')) as month_year"))
            ->where('ibr_no', \auth()->user()->ibr_no)
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            ->get();



//        DB::enableQueryLog();

        $ibr_in_direct_com = IbrIndirectCommission::select("ibr_no",
            DB::raw("(sum(amount)) as total"),
            DB::raw("(DATE_FORMAT(created_at, '%b-%Y')) as month_year"))
            ->where('ibr_no', \auth()->user()->ibr_no)
            ->whereMonth('created_at','<', Carbon::now()->startOfMonth()->subMonthsWithNoOverflow(3))
            ->orWhereMonth('created_at','>', Carbon::now()->startOfMonth()->subMonthsWithNoOverflow(3))
            ->orderBy('created_at')
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            ->get();

//        dd(DB::getQueryLog());
        return view('ibr.dashboard', compact('ibr_direct_com','ibr_in_direct_com'));
    }

    public function business_referrals(): Factory|View|Application
    {
        $referrals = Business::with('user')->where('ibr', auth()->guard('ibr')->user()->ibr_no)
                        ->get();
        return view('ibr.referrals.businessReferrals', compact('referrals'));
    }

    public function ibr_referrals(): Factory|View|Application
    {
        $referrals = Ibr::where('referred_by', auth()->guard('ibr')->user()->ibr_no)
                        ->select(['name', 'email', 'mobile_number'])
                        ->get();
        return view('ibr.referrals.ibrReferrals', compact('referrals'));
    }

    public function profileEdit(): Factory|View|Application
    {
        return view('ibr.credentials.edit');
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        Validator::make($request->all(),[
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
        ])->validate();

        if ($request->current_password != ''){
            if (!(Hash::check($request->get('current_password'), Auth::guard('ibr')->user()->getAuthPassword())))
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

        Ibr::where('id', auth()->guard('ibr')->id())->update(['password' => Hash::make($request->password)]);
        return redirect()->route('ibr.dashboard')->with('success', __('portal.Profile updated successfully!!'));

    }
}
