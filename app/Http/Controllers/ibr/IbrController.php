<?php

namespace App\Http\Controllers\ibr;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Ibr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IbrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:ibr');
    }

    public function dashboard(): Factory|View|Application
    {
        return view('ibr.dashboard');
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
}
