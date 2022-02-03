<?php

namespace App\Http\Controllers\ibr;

use App\Http\Controllers\Controller;
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

    public function referrals(): Factory|View|Application
    {
        $referrals = Ibr::where('referred_by', auth()->guard('ibr')->user()->ibr_no)
                        ->select(['name', 'email', 'mobile_number'])
                        ->get();
        return view('ibr.referrals', compact('referrals'));
    }
}
