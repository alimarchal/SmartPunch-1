<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Office;
use App\Models\User;
use App\Notifications\NewEmployeeRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('business_id', auth()->user()->business_id)->get()->except(auth()->id());
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        $businesses = Business::with('user','offices')->where('user_id', auth()->id())->get();
        $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
        return view('employee.create', compact('businesses', 'offices'));
    }

    /*public function store(Request $request)
    {
        Validator::make($request->all(), [
            'business_id' => ['required'],
            'office_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ])->validate();

        $role = Role::with('permissions')->where('name', 'employee')->first();
        $permissions = $role->permissions->pluck('name');

        $password = mt_rand(1,99999999);

        $data = [
            'business_id' => $request->business_id,
            'office_id' => $request->office_id,
            'employee_business_id' => $request->employee_business_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'user_role' => $role->id,
        ];

        $user = User::create($data)->syncPermissions($permissions);

        $user->notify(new NewEmployeeRegistration($user, $password));

        return redirect()->route('employeeIndex');
    }*/
}
