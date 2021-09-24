<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasPermissionTo('view business'))
        {
            $business = Business::where('user_id', auth()->id())->first();

            return view('business.index', compact('business'));
        }

        return redirect()->back();
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

    public function edit($businessID)
    {
        if (auth()->user()->hasPermissionTo('update business'))
        {
            $business = Business::firstWhere('id', decrypt($businessID));

            return view('business.edit', compact('business'));
        }

        return redirect()->back();
    }

    public function update(Request $request, $id): RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('update business'))
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
                $path = $request->file('logo')->store('', 'public');
                Business::where('id', decrypt($id))->update(['company_logo' => $path]);
            }

            return redirect()->route('businessIndex')->with('success', 'Business details updated successfully!!');
        }

        return redirect()->back();
    }

                                    /* Functions for only Super Admin Started */

    /* Function for admin to retrieve all businesses  */
    public function allBusinesses()
    {
        if (auth()->user()->hasPermissionTo('suspend business'))
        {
            $businesses = Business::with('offices', 'user')->get();
            return view('business.admin.index', compact('businesses'));
        }
        return redirect()->back()->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Function for admin to retrieve all offices of a business  */
    public function businessOffices($id)
    {
        if (auth()->user()->hasPermissionTo('suspend business'))
        {
            $offices = Office::with('employees', 'business')->where('business_id', decrypt($id))->get();
            return view('business.admin.liftOfOffices', compact('offices'));
        }
        return redirect()->back()->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Function for admin to retrieve all employees of an office  */
    public function businessOfficesEmployees($id)
    {
        if (auth()->user()->hasPermissionTo('suspend business'))
        {
            $office = Office::with('employees')->where('id', decrypt($id))->first();
            return view('business.admin.listOfOfficeEmployees', compact('office'));
        }
        return redirect()->back()->with('error', __('portal.You do not have permission for this action.'));
    }

                                    /* Functions for only Super Admin Ended */
}
