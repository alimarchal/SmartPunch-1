<?php

namespace App\Http\Controllers\v1\ibr;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Ibr;
use App\Models\IbrDirectCommission;
use App\Models\IbrIndirectCommission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function profileUpdate(Request $request): JsonResponse
    {
        Validator::make($request->all(),[
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
        ])->validate();

        if ($request->current_password != ''){
            if (!(Hash::check($request->get('current_password'), Auth::guard('ibr_api')->user()->getAuthPassword())))
            {
                return response()->json(['error' => 'Entered password did not matched our records']);
            }
        }
        if ($request->password != ''){
            if (strcmp($request->get('current_password'),$request->get('password'))==0)
            {
                return response()->json(['error' => 'Your current password cannot be same to new password']);
            }
        }

        Ibr::where('id', auth()->guard('ibr_api')->id())->update(['password' => Hash::make($request->password)]);
        return response()->json(['Success' => 'Profile updated successfully!!']);
    }

    public function directCommissions(): JsonResponse
    {
        $directCommissions = IbrDirectCommission::where([
            'ibr_no' => auth()->guard('ibr_api')->user()->ibr_no,
            ])
            ->get();

        if (count($directCommissions) > 0){
            return response()->json(['DirectCommissions' => $directCommissions]);
        }
        else{
            return response()->json(['data' => 'No data found'], 404);
        }
    }

    public function inDirectCommissions(): JsonResponse
    {
        $inDirectCommissions = IbrIndirectCommission::where([
            'ibr_no' => auth()->guard('ibr_api')->user()->ibr_no,
        ])->get();

        if (count($inDirectCommissions) > 0){
            return response()->json(['InDirectCommissions' => $inDirectCommissions]);
        }
        else{
            return response()->json(['data' => 'No data found'], 404);
        }
    }

}
