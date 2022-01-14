<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Office;
use App\Models\User;
use App\Models\UserHasSchedule;
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
            if (\auth()->user()->user_role == 2) /* 2 => Admin */
            {
                $employees = User::where('business_id', auth()->user()->business_id)->orderByDesc('created_at')->get()->except([auth()->id()]);
                return view('employee.index', compact('employees'));
            }
            if (\auth()->user()->user_role == 3) /* 3 => Manager */
            {
                $employees = User::where('business_id', auth()->user()->business_id)->where('user_role', '!=', 2)->orderByDesc('created_at')->get()->except([auth()->id()]);
                return view('employee.index', compact('employees'));
            }
            if (\auth()->user()->user_role == 4) /* 4 => Supervisor */
            {
                $userRoles = [2,3];
                $employees = User::where('business_id', auth()->user()->business_id)->whereNotIn('user_role', $userRoles)->orderByDesc('created_at')->get()->except([auth()->id()]);
                return view('employee.index', compact('employees'));
            }

        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function create()
    {
        if (auth()->user()->hasPermissionTo('create employee'))
        {
            /* If user is admin(2) */
            if (auth()->user()->user_role == 2) {
                $roles = Role::with('permissions')->get()->except(1);
                $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
                return view('employee.create', compact('roles', 'offices'));
            }
            /* If user is manager(3) */
            if (auth()->user()->user_role == 3) {
                $roles = Role::with('permissions')->whereNotIn('id', [1,2,3])->get();
                $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
                return view('employee.create', compact('roles', 'offices'));
            }
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('create employee'))
        {
            $role = Role::with('permissions')->where('id', $request->role_id)->first();
            $permissions = $role->permissions->pluck('name');

            $data = [
                'business_id' => auth()->user()->business_id,
                'office_id' => $request->office_id,
                'employee_business_id' => $request->employee_business_id,
                'schedule_id' => $request->schedule,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'user_role' => $role->id,
            ];

            $user = User::create($data)->assignRole($role)->syncPermissions($permissions);
            UserHasSchedule::create([
                'schedule_id' => $request->schedule,
                'user_id' => $user->id,
            ]);

            $user->notify(new NewEmployeeRegistration($user, $request->password, $role->name, $request->email, $user->otp));

            return redirect()->route('employeeIndex')->with('success', __('portal.Employee added successfully!!!'));
        }

        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function show($id)
    {
        $employee = User::with('office', 'userSchedules.schedule')->findOrFail(decrypt($id));
        $permissions = Permission::get()->pluck( 'name', 'id');
        return view('employee.show', compact('employee', 'permissions'));
    }

    public function edit($id)
    {
        if (auth()->user()->hasPermissionTo('update employee'))
        {
            $employee = User::with('office', 'business', 'punchTable', 'userSchedules', 'office.officeSchedules')->where('id', decrypt($id))->first();
            $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
            $permissions = Permission::get()->pluck( 'name', 'id');
            return view('employee.edit', compact('employee', 'offices', 'permissions'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('update employee'))
        {
            Validator::make($request->all(), [
                'office_id' => ['required'],
                'status' => ['required'],
                'schedule_id' => ['required']
            ],[
                'office_id.required' => __('validation.custom.office_id.required'),
                'schedule_id.required' => __('validation.custom.schedule.required'),
            ])->validate();

            $user = User::findOrFail(decrypt($id));

            $user->update([
                'office_id' => $request->office_id,
                'schedule_id' => $request->schedule_id,
                'status' => $request->status,
            ]);
            $user->save();

            $permissions = $user->getAllPermissions();
            $user->revokePermissionTo($permissions);
            $user->syncPermissions($request->permissions);

            $user->userSchedules()->update([
                'schedule_id' => $request->schedule_id,
            ]);

            return redirect()->route('employeeIndex')->with('success', 'Employee updated successfully!!');
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Commented in view because of the requirement ie account should be suspended rather than deleting it */
    public function delete($id): RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('delete employee'))
        {
            $employee = User::findOrFail(decrypt($id));

            $permissions = $employee->getAllPermissions();
            $employee->revokePermissionTo($permissions);

            $employee->delete();
            return redirect()->route('employeeIndex')->with('success', __('portal.Employee deleted successfully!!'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function profileEdit()
    {
        return view('credentials.edit');
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        Validator::make($request->all(),[
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
            'logo' => ['mimes:jpg,bmp,png'],
        ])->validate();

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
            User::where('id', auth()->id())->update(['profile_photo_path' => $path]);
        }

        User::where('id', auth()->id())->update(['password' => Hash::make($request->password)]);
        return redirect()->route('dashboard')->with('success', __('portal.Profile updated successfully!!'));

    }

    /* Retrieving permissions of the selected role */
    public function permissions(Request $request): JsonResponse
    {
        $permissions = Role::with('permissions')->where('id', $request->role_id)->first()->getAllPermissions()->pluck('name');

        return response()->json(['permissions' => $permissions]);
    }
}
