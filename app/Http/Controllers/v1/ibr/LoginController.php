<?php

namespace App\Http\Controllers\v1\ibr;

use App\Http\Controllers\Controller;
use App\Mail\OTPSent;
use App\Models\Ibr;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request): Response
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        if(auth()->guard('ibr')->attempt(['email' => request('email'), 'password' => request('password')]))
        {
            $ibr = Ibr::find(auth()->guard('ibr')->user()->id);

            if ($ibr->status == 0)
            {
                return response([
                    'status' => ['Your account is suspended'],
                ], 403);
            }

            $ibr->device_name = $request->device_name;
            $ibr->save();
            return response([
                'token' => $ibr->createToken($request->device_name)->plainTextToken,
                'user' => $ibr,
            ], 200);
        }
        else
        {
            return response([
                'error' => ['The provided credentials are incorrect.'],
            ], 404);
        }

    }

    public function verify_otp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'string', 'max:255'],
        ],[
            'otp.required' => 'OTP is required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()],422);
        }

        $ibr = Ibr::findOrFail(auth()->user()->id);

        if ($ibr->otp != $request->otp)
        {
            return response()->json([
                'error' => ['Incorrect OTP entered.'],
            ], 404);
        }
        $ibr->email_verified_at = Carbon::now()->toDateTimeString();
        $ibr->verified = 1;
        $ibr->save();

        return response()->json([
            'Status' => 'Verified!'
        ]);
    }

    public function resend_otp(): JsonResponse
    {
        $otp = mt_rand(1000, 9999);
        $ibr = Ibr::firstWhere('id', auth()->id());
        if (!$ibr)
        {
            return response()->json(['error' => 'Record Not Found'],404);
        }
        $ibr->update(['otp' => $otp]);
        Mail::to($ibr->email)->send(new OTPSent($ibr->otp));

        return response()->json(['success' => 'OTP resent to your registered email.']);
    }

    public function logout()
    {
        auth()->guard('ibr_api')->user()->tokens()->delete();
        return response(['message' => 'Logged out'], 200);
    }
}
