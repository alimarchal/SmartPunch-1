<?php

namespace App\Http\Controllers\v1\ibr;

use App\Http\Controllers\Controller;
use App\Models\Ibr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IbrController extends Controller
{
    public function referrals(): JsonResponse
    {
        $referrals = Ibr::where('referred_by', auth()->guard('ibr_api')->user()->ibr_no)
            ->select(['name', 'email', 'mobile_number'])
            ->get();

        return response()->json([
            'referrals' => $referrals,
        ]);
    }
}
