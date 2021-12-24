<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewEmployeeRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        if (auth()->user()->hasPermissionTo('create employee'))
        {
            $validator = Validator::make($request->all(), [
                'office_id' => ['required'],
                'role_id' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8',],
            ], [
                'office_id.required' => 'Please select an office',
                'role_id.required' => 'Please select a role',
                'name.required' => 'Name is required',
                'email.required' => 'Name is required',
                'password.required' => 'Password is required',
                'password.min' => 'Password must contain minimum 8 characters',
            ]);

            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()]);
            }

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

//            $user->notify(new NewEmployeeRegistration($user, $request->password, $role->name, $request->email));

            return response()->json(['message' => 'Employee created', 'user' => $user]);
        }

        return response()->json(['message' => 'Forbidden!'], 403);
    }

    public function status($id, Request $request): JsonResponse
    {
        if (auth()->user()->hasPermissionTo('update employee'))
        {
            $employee = User::findOrFail($id);

            $employee->update(['status' => $request->status]);
            return response()->json(['message' => 'Employee status updated successfully!!!']);
        }

        return response()->json(['message' => 'Forbidden!'], 403);
    }
}
