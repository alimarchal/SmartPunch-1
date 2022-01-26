<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Office;
use App\Models\User;
use App\Models\UserHasSchedule;
use App\Models\UserOffice;
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
    public function index(): JsonResponse
    {
        if (auth()->user()->hasPermissionTo('view employee'))
        {
            if (\auth()->user()->user_role == 2) /* 2 => Admin */
            {
                $employees = User::with(['userOffice' => function ($query) {
                    $query->where('status', 1);
                }, 'userOffice.office'])
                    ->where('business_id', auth()->user()->business_id)
                    ->orderByDesc('created_at')
                    ->get()
                    ->except([auth()->id()]);
                if (!$employees)
                {
                    return response()->json(['message' => 'No employees found'], 404);
                }
                return response()->json(['employees' => $employees]);
            }
            if (\auth()->user()->user_role == 3) /* 3 => Manager */
            {
                $employees = User::with(['userOffice' => function ($query) {
                    $query->where('status', 1);
                }])
                    ->where('business_id', auth()->user()->business_id)
                    ->where('user_role', '!=', 2)
                    ->orderByDesc('created_at')
                    ->get()
                    ->except([auth()->id()]);
                if (!$employees)
                {
                    return response()->json(['message' => 'No employees found'], 404);
                }
                return response()->json(['employees' => $employees]);
            }
            if (\auth()->user()->user_role == 4) /* 4 => Supervisor */
            {
                $userRoles = [2,3];
                $employees = User::with(['userOffice' => function ($query) {
                    $query->where('status', 1);
                }])
                    ->where('business_id', auth()->user()->business_id)
                    ->whereNotIn('user_role', $userRoles)
                    ->orderByDesc('created_at')
                    ->get()
                    ->except([auth()->id()]);
                if (!$employees)
                {
                    return response()->json(['message' => 'No employees found'], 404);
                }
                return response()->json(['employees' => $employees]);
            }
        }

        return response()->json(['message' => 'Forbidden!'], 403);
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        if (auth()->user()->hasPermissionTo('create employee'))
        {
            $role = Role::with('permissions')->where('id', $request->role_id)->first();
            $permissions = $role->permissions->pluck('name');
            $otp = mt_rand(1000, 9999);

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
                'otp' => $otp,
            ];

            $user = User::create($data)->assignRole($role)->syncPermissions($permissions);
            UserHasSchedule::create([
                'schedule_id' => $request->schedule,
                'user_id' => $user->id,
            ]);
            UserOffice::create([
                'user_id' => $user->id,
                'office_id' => $request->office_id,
            ]);

            $user->notify(new NewEmployeeRegistration($user, $request->password, $role->name, $request->email, $user->otp));

            return response()->json(['message' => 'Employee created', 'user' => $user]);
        }

        return response()->json(['message' => 'Forbidden!'], 403);
    }

    public function show($id): JsonResponse
    {
        $employee = User::with('office', 'userSchedule.schedule')->findOrFail($id);
        $userSchedule = $employee->userSchedule()->firstWhere('status', 1);
        $permissions = Permission::get()->pluck( 'name', 'id');
        return response()->json(['employee' => $employee, 'userSchedule' => $userSchedule, 'permissions' => $permissions]);
    }

    public function update(Request $request, $id): JsonResponse
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

            $user = User::findOrFail($id);

            $user->update([
                'office_id' => $request->office_id,
                'schedule_id' => $request->schedule_id,
                'status' => $request->status,
            ]);
            $user->save();

            $permissions = $user->getAllPermissions();
            $user->revokePermissionTo($permissions);
            $user->syncPermissions($request->permissions);

            $previousAssignedSchedule = $user->userSchedule()->firstWhere('status', 1);
            $previousAssignedOffice = $user->userOffice()->firstWhere('status', 1);

            if ($previousAssignedSchedule->schedule_id != $request->schedule_id)
            {

                /* Update previous employee schedule status */
                $user->userSchedule()->firstWhere('status', 1)->update([
                    'status' => 0,
                ]);

                $user->userSchedule()->create([
                    'schedule_id' => $request->schedule_id,
                    'user_id' => $user->id,
                    'previous_schedule_id' => $previousAssignedSchedule->schedule_id,
                ]);
            }

            if (isset($previousAssignedOffice) && $previousAssignedOffice->office_id != $request->office_id)
            {
                /* Update previous employee Office status */
                $user->userOffice()->firstWhere('status', 1)->update([
                    'status' => 0,
                ]);

                $user->userOffice()->create([
                    'user_id' => $user->id,
                    'office_id' => $request->office_id,
                    'previous_office_id' => $previousAssignedOffice->office_id,
                ]);
            }

            return response()->json(['message' => 'Employee updated successfully!!']);
        }
        return response()->json(['message' => 'Forbidden!'], 403);
    }

    public function profileUpdate(Request $request): JsonResponse
    {
        Validator::make($request->all(),[
            'password' => ['required', 'confirmed'],
            'current_password' => ['required'],
            'logo' => ['mimes:jpg,bmp,png'],
        ])->validate();

        if ($request->current_password != ''){
            if (!(Hash::check($request->get('current_password'), Auth::user()->getAuthPassword())))
            {
                return response()->json(['error' => 'Entered password did not matched our records']);
            }
        }
        if ($request->password != ''){
            if (strcmp($request->get('current_password'),$request->get('password'))==0)
            {
                return response()->json(['error' => 'Your current password cannot be same to new password']);
            }
        }

        if ($request->hasFile('logo'))
        {
            $path = $request->file('logo')->store('', 'public');
            User::where('id', auth()->id())->update(['profile_photo_path' => $path]);
        }

        User::where('id', auth()->id())->update(['password' => Hash::make($request->password)]);
        return response()->json(['Success' => 'Profile updated successfully!!']);
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
