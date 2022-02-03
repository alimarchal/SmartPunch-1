<?php

namespace App\Http\Controllers\v1\ibr;

use App\Http\Controllers\Controller;
use App\Models\Ibr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

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
}
