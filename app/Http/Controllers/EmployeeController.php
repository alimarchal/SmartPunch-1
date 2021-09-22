<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use App\Notifications\NewEmployeeRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('business_id', auth()->user()->business_id)->where('user_role', '!=', 2)->get()->except([auth()->id()]);
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::with('permissions')->get()->except(1);
        $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
        return view('employee.create', compact('roles', 'offices'));
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'office_id' => ['required'],
            'role_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8',],
        ])->validate();

        $role = Role::with('permissions')->where('id', $request->role_id)->first();
        $permissions = $role->permissions->pluck('name');

        $data = [
            'business_id' => auth()->user()->business_id,
            'office_id' => $request->office_id,
            'employee_business_id' => $request->employee_business_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'user_role' => $role->id,
        ];

        $user = User::create($data)->syncPermissions($permissions);

        $user->notify(new NewEmployeeRegistration($user, $request->password, $role->name, $request->email));

        return redirect()->route('employeeIndex')->with('success', 'Employee added successfully!!!');
    }

    public function edit($id)
    {
        $employee = User::with('office', 'business', 'punchTable')->where('id', decrypt($id))->first();
        $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
        $permissions = Permission::get()->pluck( 'name', 'id');
        return view('employee.edit', compact('employee', 'offices', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'office_id' => ['required']
        ])->validate();

        $user = User::where('id', decrypt($id))->first();

        $user->update(['office_id' => $request->office_id]);
        $user->save();

        $permissions = $user->getAllPermissions();
        $user->revokePermissionTo($permissions);
        $user->syncPermissions($request->permissions);

        return redirect()->route('employeeIndex')->with('success', 'Employee updated successfully!!');
    }

    /* Retrieving permissions of the selected role */
    public function permissions(Request $request): JsonResponse
    {
        $permissions = Role::with('permissions')->where('id', $request->role_id)->first()->getAllPermissions()->pluck('name');

        return response()->json(['permissions' => $permissions]);
    }
}
