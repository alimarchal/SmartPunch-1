<?php

namespace App\Http\Controllers\v1\ibr;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Ibr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IbrController extends Controller
{
    public function business_referrals(): JsonResponse
    {
        $business_referrals = Business::with('user')->where('ibr', auth()->guard('ibr_api')->user()->ibr_no)
            ->get();

        return response()->json([
            'business_referrals' => $business_referrals,
        ]);
    }

    public function ibr_referrals(): JsonResponse
    {
        $ibr_referrals = Ibr::where('referred_by', auth()->guard('ibr_api')->user()->ibr_no)
            ->select(['name', 'email', 'mobile_number'])
            ->get();

        return response()->json([
            'ibr_referrals' => $ibr_referrals,
        ]);
    }
}
