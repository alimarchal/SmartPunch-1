<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use App\Notifications\NewEmployeeRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasPermissionTo('view employee'))
        {
            $employees = User::where('business_id', auth()->user()->business_id)->where('user_role', '!=', 2)->get()->except([auth()->id()]);
            return view('employee.index', compact('employees'));
        }
    }

    public function create()
    {
        if (auth()->user()->hasPermissionTo('create employee'))
        {
            /* if user is admin(2) */
            if (auth()->user()->user_role == 2) {$roles = Role::with('permissions')->get()->except(1);}
            if (auth()->user()->user_role == 3) {$roles = Role::with('permissions')->whereNotIn('id', [1,2])->get();}
            $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
            return view('employee.create', compact('roles', 'offices'));
        }
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

    public function show($id)
    {
        $employee = User::with('office')->findOrFail(decrypt($id));
        $permissions = Permission::get()->pluck( 'name', 'id');
        return view('employee.show', compact('employee', 'permissions'));
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
        if (auth()->user()->hasPermissionTo('update employee'))
        {
            Validator::make($request->all(), [
                'office_id' => ['required'],
                'status' => ['required']
            ])->validate();

            $user = User::findOrFail(decrypt($id));

            $user->update([
                'office_id' => $request->office_id,
                'status' => $request->status,
            ]);
            $user->save();

            $permissions = $user->getAllPermissions();
            $user->revokePermissionTo($permissions);
            $user->syncPermissions($request->permissions);

            return redirect()->route('employeeIndex')->with('success', 'Employee updated successfully!!');
        }
    }

    public function delete($id)
    {
        if (auth()->user()->hasPermissionTo('delete employee'))
        {
            $employee = User::findOrFail(decrypt($id));

            $permissions = $employee->getAllPermissions();
            $employee->revokePermissionTo($permissions);

            $employee->delete();
            return redirect()->route('employeeIndex')->with('success', __('portal.Employee deleted successfully!!'));
        }

    }

    public function profileEdit()
    {
        return view('credentials.edit');
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        Validator::make($request->all(),[
            'current_password' => ['required'],
            'password' => ['required', 'confirmed'],
            'logo' => ['mimes:jpg,bmp,png'],
        ]);

        if ($request->current_password != ''){
            if (!(Hash::check($request->get('current_password'), Auth::user()->getAuthPassword())))
            {
                return redirect()->back()->with('error', 'Current password not matched');
            }
        }
        if ($request->password != ''){
            if (strcmp($request->get('current_password'),$request->get('password'))==0)
            {
                return redirect()->back()->with('error', 'Your current password cannot be same to new password');

            }
        }

        if ($request->hasFile('logo'))
        {
            $path = $request->file('logo')->store('', 'public');
            User::where('id', \auth()->id())->update(['profile_photo_path' => $path]);
        }

        User::where('id', \auth()->id())->update(['password' => Hash::make($request->password)]);

        return redirect()->route('dashboard')->with('success', __('portal.Profile updated successfully!!'));

    }

    /* Retrieving permissions of the selected role */
    public function permissions(Request $request): JsonResponse
    {
        $permissions = Role::with('permissions')->where('id', $request->role_id)->first()->getAllPermissions()->pluck('name');

        return response()->json(['permissions' => $permissions]);
    }
}
