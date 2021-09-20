<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        $business = Business::where('user_id', auth()->id())->first();

        return view('business.index', compact('business'));
    }

    public function create()
    {
        return view('business.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'company_name' => ['required', 'string', 'max:255'],
            'country_name' => ['required'],
            'city_name' => ['required'],
            'country_code' => ['required'],
            'logo' => ['required','mimes:jpg,bmp,png'],
        ])->validate();

        $path = $request->file('logo')->store('', 'public');
        $request->merge(['company_logo' => $path]);

        $data = [
            'user_id' => auth()->id(),
            'company_name' => $request->company_name,
            'country_name' => $request->country_name,
            'city_name' => $request->city_name,
            'country_code' => $request->country_code,
            'company_logo' => $request->company_logo,
        ];

        $business = Business::create($data);

        User::where('id', auth()->id())->update(['business_id' => $business->id]);

        return redirect()->route('dashboard')->with('success', 'Business details added successfully!');
    }
}
