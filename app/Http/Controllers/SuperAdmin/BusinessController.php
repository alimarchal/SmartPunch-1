<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Office;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /* Function to retrieve all businesses  */
    public function allBusinesses(): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('suspend business'))
        {
            $businesses = Business::with('offices', 'user')->get();
            return view('superAdmin.business.index', compact('businesses'));
        }
        return redirect()->back()->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Function to retrieve all offices of a business  */
    public function businessOffices($id): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('suspend business'))
        {
            $offices = Office::with('employees', 'business')->where('business_id', decrypt($id))->get();
            return view('superAdmin.business.list_of_offices', compact('offices'));
        }
        return redirect()->back()->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Function to retrieve all employees of an office  */
    public function businessOfficesEmployees($id): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('suspend business'))
        {
            $office = Office::with('employees')->where('id', decrypt($id))->first();
            return view('superAdmin.business.list_of_office_employees', compact('office'));
        }
        return redirect()->back()->with('error', __('portal.You do not have permission for this action.'));
    }

}
