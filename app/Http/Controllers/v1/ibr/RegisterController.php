<?php

namespace App\Http\Controllers\v1\ibr;

use App\Http\Controllers\Controller;
use App\Http\Requests\IbrStoreRequest;
use App\Mail\forgotPassword;
use App\Mail\ibr\verifyEmail;
use App\Mail\OTPSent;
use App\Models\Ibr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function store(IbrStoreRequest $request)
    {
        if (!is_null($request->referred_by))
        {
            $reference = Ibr::where('ibr_no', $request->referred_by)->first('ibr_no');
            if (isset($reference))
            {
                $request->merge(['referred_by' => $reference['ibr_no']]);
            }
        }

        $otp = mt_rand(1000, 9999);

        $data = [
            'referred_by' => $request->referred_by,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'gender' => $request->gender,
            'country_of_business' => $request->country_of_business,
            'country_of_bank' => $request->country_of_bank,
            'bank' => $request->bank,
            'iban' => $request->iban,
            'currency' => $request->currency,
            'mobile_number' => $request->mobile_number,
            'otp' => $otp,
            'mac_address' => $request->mac_address,
            'device_name' => $request->device_name,
        ];

        $ibr = Ibr::create($data);

        Ibr::where('id', $ibr->id)->update([
            'ibr_no' =>  'IBR'.$ibr->id,
        ]);

        Mail::to($ibr->email)->send(new OTPSent($ibr->otp));

        \auth()->guard('ibr')->login($ibr);
        return response()->json([
            'success' => 'Registered successfully !!!',
            'token' => $ibr->createToken($request->device_name)->plainTextToken,
            'ibr' => $ibr
        ]);
    }

    public function forgot_password(Request $request): JsonResponse
    {
        $ibr = Ibr::firstWhere('email', $request->email);
        if (!$ibr)
        {
            return response()->json(['error' => 'Record Not Found'],404);
        }
        $password = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 9);
        $ibr->update(['password' => Hash::make($password)]);
        Mail::to($ibr->email)->send(new forgotPassword($password));

        return response()->json(['success' => 'New password is sent to your registered email.']);
    }

    public function logout()
    {
        auth()->guard('ibr_api')->user()->tokens()->delete();
        return response(['message' => 'Logged out'], 200);
    }
}
