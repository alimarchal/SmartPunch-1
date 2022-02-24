<?php

namespace App\Http\Controllers\ibr;

use App\Http\Controllers\Controller;
use App\Http\Requests\IbrStoreRequest;
use App\Mail\ibr\verifyEmail;
use App\Models\City;
use App\Models\Ibr;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(): View
    {
        $countries = \DB::table('countries')->get();
        return view('ibr.auth.register', compact('countries'));
    }

    public function store(IbrStoreRequest $request): RedirectResponse
    {
        if (!is_null($request->referred_by))
        {
            $reference = Ibr::where('ibr_no', $request->referred_by)->first('ibr_no');
            if (isset($reference))
            {
                $request->merge(['referred_by' => $reference['ibr_no']]);
            }
        }
        $verifyToken = sha1(rand(1, 100));

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referred_by' => $request->referred_by,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'country_of_business' => $request->country_of_business,
            'city_of_business' => $request->city_of_business,
            'country_of_bank' => $request->country_of_bank,
            'bank' => $request->bank,
            'iban' => $request->iban,
            'currency' => $request->currency,
            'mobile_number' => $request->mobile_number,
            'verify_token' => $verifyToken,
        ];

        $ibr = Ibr::create($data);

        Ibr::where('id', $ibr->id)->update([
            'ibr_no' =>  'IBR'.$ibr->id,
        ]);

        Mail::to($ibr)->send(new verifyEmail($ibr));

        \auth()->guard('ibr')->login($ibr);
        return redirect()->route('ibr.ibrEmailVerify');
    }

    public function searchCities(Request $request): JsonResponse
    {
        $cities = City::where('country_id', $request->id)->get();
        return response()->json(['cities' => $cities]);
    }

    public function email_verify(): View|RedirectResponse
    {
        if (\auth()->guard('ibr')->user()->verified == 1) {
            return redirect()->route('ibr.dashboard');
        }
        return view('ibr.verify-email');
    }

    public function email_verify_check($token): RedirectResponse
    {
        if (auth()->guard('ibr')->user()->verify_token == $token) {
            Ibr::where('id', auth()->guard('ibr')->user()->id)->update([
                'email_verified_at' => Carbon::now(),
                'verified' => 1,
            ]);
            return redirect()->route('ibr.dashboard');
        }

        session()->flash('message', 'Something went wrong! Login to try again.');
        Auth::guard('ibr')->logout();
        return redirect()->route('ibr.login');
    }

    public function resend_email_verification(): RedirectResponse
    {
        $ibr = Ibr::where('id', auth()->guard('ibr')->user()->id)->first();

        $verifyToken = sha1($ibr->name);

        Ibr::where('id', $ibr->id)->update([
            'verify_token' => $verifyToken,
        ]);

        Mail::to($ibr)->send(new verifyEmail($ibr));

        session()->flash('status', 'verification-link-sent');
        return redirect()->back();
    }

    // used for to search ibr for reference
    public function search_ibr(Request $request): JsonResponse
    {
        $ibr = Ibr::where('ibr_no', $request->referred_no)->first();

        if (!$ibr)
        {
            return response()->json( ['status' => 0]);
        }
        return response()->json(['data' => $ibr->name]);
    }
}
