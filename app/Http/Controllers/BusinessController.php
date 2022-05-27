<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Country;
use App\Models\Office;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('view business'))
        {
            $business = Business::where('user_id', auth()->id())->first();

            return view('business.index', compact('business'));
        }

        return redirect()->back();
    }

    public function create(): View
    {
        $countries = Country::get();
        return view('business.create', compact('countries'));
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

    public function edit($businessID): View|RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('update business'))
        {
            $countries = Country::get();
            $business = Business::firstWhere('id', decrypt($businessID));
            return view('business.edit', compact('business', 'countries'));
        }

        return redirect()->back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('update business'))
        {
            Validator::make($request->all(), [
                'company_name' => ['required', 'string', 'max:255'],
                'country_name' => ['required'],
                'city_name' => ['required'],
                'country_code' => ['required'],
            ])->validate();

            $data = [
                'company_name' => $request->company_name,
                'country_name' => $request->country_name,
                'city_name' => $request->city_name,
                'country_code' => $request->country_code,
            ];

            Business::where('id', decrypt($id))->update($data);

            if ($request->hasFile('logo'))
            {
                if (isset(auth()->user()->business->company_logo)){
                    $image = public_path('storage/'.auth()->user()->business->company_logo);
                    if(File::exists($image)){
                        unlink($image);
                    }
                }
                $path = $request->file('logo')->store('', 'public');
                Business::where('id', decrypt($id))->update(['company_logo' => $path]);
            }

            return redirect()->route('businessIndex')->with('success', 'Business details updated successfully!!');
        }

        return redirect()->back();
    }
}
