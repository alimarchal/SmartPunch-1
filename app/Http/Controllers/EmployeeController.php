<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Models\Office;
use App\Models\PunchTable;
use App\Models\User;
use App\Models\UserHasSchedule;
use App\Models\UserOffice;
use App\Notifications\NewEmployeeRegistration;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('view employee'))
        {
            if (\auth()->user()->user_role == 2) /* 2 => Admin */
            {
                $employees = User::where('business_id', auth()->user()->business_id)->orderByDesc('created_at')->get()->except([auth()->id()]);
                return view('employee.index', compact('employees'));
            }
            if (\auth()->user()->user_role == 3) /* 3 => Manager */
            {
                $employees = User::where(['business_id' => auth()->user()->business_id, 'office_id' => \auth()->user()->office_id])
                    ->where('user_role', '!=', 2)
                    ->orderByDesc('created_at')
                    ->get()
                    ->except([auth()->id()]);
                return view('employee.index', compact('employees'));
            }
            if (\auth()->user()->user_role == 4) /* 4 => Supervisor */
            {
                $userRoles = [2,3];
                $employees = User::where(['business_id' => auth()->user()->business_id, 'office_id' => \auth()->user()->office_id])
                    ->whereNotIn('user_role', $userRoles)
                    ->orderByDesc('created_at')->get()
                    ->except([auth()->id()]);
                return view('employee.index', compact('employees'));
            }

        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function create(): View|RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('create employee'))
        {
            /* If user is admin(2) */
            if (auth()->user()->user_role == 2) {
                $roles = Role::with('permissions')->get()->except(['id' => 1]);
                $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
                /* Same lines of code so combined it in extracted function */
                return $this->extracted($roles, $offices);
            }
            /* If user is manager(3) */
            if (auth()->user()->user_role == 3) {
                $roles = Role::with('permissions')->whereNotIn('id', [1,2,3])->get();
                $offices = Office::with('business')->where(['business_id' => auth()->user()->business_id, 'id' => \auth()->user()->office_id])->get();
                /* Same lines of code so combined it in extracted function */
                return $this->extracted($roles, $offices);
            }
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('create employee'))
        {
            $role = Role::with('permissions')->where('id', $request->role_id)->first();
            $permissions = $role->permissions->pluck('name');

            if (!is_null($request->parent_id) && $request->parent_id != 0)
            {
                $parentID = $request->parent_id;
            }
            else
            {
                $parentID = 0;
            }

            $data = [
                'business_id' => auth()->user()->business_id,
                'office_id' => $request->office_id,
                'employee_business_id' => $request->employee_business_id,
                'parent_id' => $parentID,
                'schedule_id' => $request->schedule,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'user_role' => $role->id,
            ];

            $user = User::create($data)->assignRole($role)->syncPermissions($permissions);
            $user->designation = $role->name;
            $user->save();
            UserHasSchedule::create([
                'schedule_id' => $request->schedule,
                'user_id' => $user->id,
            ]);
            UserOffice::create([
                'user_id' => $user->id,
                'office_id' => $request->office_id,
            ]);

            $user->notify(new NewEmployeeRegistration($user, $request->password, $role->name, $request->email, $user->otp));

            return redirect()->route('employeeIndex')->with('success', __('portal.Employee added successfully!!!'));
        }

        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function show($id, Request $request): View
    {
        $employee = User::with('office', 'userSchedule.schedule')->findOrFail(decrypt($id));
        $userSchedule = $employee->userSchedule()->firstWhere('status', 1);
        $permissions = Permission::get()->pluck( 'name', 'id');

        $date = null;
        /* default current month is shown */
        if (!$request->date){
            $punchedAttendancesGroupByDate = PunchTable::where('user_id', $employee->id)
                ->select(['id', 'created_at'])
                ->whereMonth('created_at', Carbon::now())
                ->get()
                ->groupBy(function ($reports) {
                    return Carbon::parse($reports->created_at)->format('Y-m-d');
                });

            $daysOfMonth = Carbon::now()->month(Carbon::now()->month)->daysInMonth;

            $dateString = array();
            for($i = 1; $i <= $daysOfMonth; $i++){
                $dateString[] = Carbon::now()->month(Carbon::now()->month)->day($i)->format('Y-m-d');
            }

            $daysCount = [];
            $data = [];

            foreach ($punchedAttendancesGroupByDate as $key => $value) {
                $daysCount[$key] = $key;
            }

            /* Assigning 0 to keys of array where there is no attendance value present */
            foreach($dateString as $key => $value){
                if(in_array($value, $daysCount)){

                    $time = Carbon::create();
                    $punchedAttendances = PunchTable::where('user_id', $employee->id)
                        ->whereDate('created_at', $value)
                        ->get()->toArray();

                    /* Calculating and replacing values for that particular date */
                    for ($i = 0; $i< (count($punchedAttendances) - 1); $i++){
                        if ($punchedAttendances[$i]['in_out_status'] == 1 && $punchedAttendances[$i+1]['in_out_status'] == 0){
                            $first = Carbon::parse($punchedAttendances[$i]['time']);
                            $second = Carbon::parse($punchedAttendances[$i+1]['time']);

                            $time = $time->add($first->diff(Carbon::parse($second)));
                        }
                    }

                    $data[$key+1] = $time->format('H:i:s');
//                $data[$key+1] = $time->toTimeString();
                }else{
                    $data[$key+1] = 0;
                }
            }
        }
        else{
            $punchedAttendancesGroupByDate = PunchTable::where('user_id', $employee->id)
                ->select(['id', 'created_at'])
                ->whereMonth('created_at', Carbon::parse($request->date)->format('m'))
                ->get()
                ->groupBy(function ($reports) {
                    return Carbon::parse($reports->created_at)->format('Y-m-d');
                });

            $daysOfMonth = Carbon::parse($request->date)->daysInMonth;

            $dateString = array();
            for($i = 1; $i <= $daysOfMonth; $i++){
                $dateString[] = Carbon::parse($request->date)->day($i)->format('Y-m-d');
            }

            $daysCount = [];
            $data = [];

            foreach ($punchedAttendancesGroupByDate as $key => $value) {
                $daysCount[$key] = $key;
            }

            /* Assigning 0 to keys of array where there is no attendance value present */
            foreach($dateString as $key => $value){
                if(in_array($value, $daysCount)){

                    $time = Carbon::create();
                    $punchedAttendances = PunchTable::where('user_id', $employee->id)
                        ->whereDate('created_at', $value)
                        ->get()->toArray();

                    /* Calculating and replacing values for that particular date */
                    for ($i = 0; $i< (count($punchedAttendances) - 1); $i++){
                        if ($punchedAttendances[$i]['in_out_status'] == 1 && $punchedAttendances[$i+1]['in_out_status'] == 0){
                            $first = Carbon::parse($punchedAttendances[$i]['time']);
                            $second = Carbon::parse($punchedAttendances[$i+1]['time']);

                            $time = $time->add($first->diff(Carbon::parse($second)));
                        }
                    }

                    $data[$key+1] = $time->format('H:i:s');
                }else{
                    $data[$key+1] = 0;
                }
            }

            /* Assigning date variable inorder to display in calendar in view */
            $date = $request->date;
        }

        return view('employee.show', compact('employee', 'permissions', 'userSchedule', 'data', 'date'));
    }

    public function edit($id): View|RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('update employee'))
        {
            $employee = User::with('office', 'business', 'punchTable', 'userSchedule', 'office.officeSchedules')->where('id', decrypt($id))->first();
            $employeeSchedule = $employee->userSchedule()->firstWhere('status', 1);
            $offices = Office::with('business')->where('business_id', auth()->user()->business_id)->get();
            $permissions = Permission::get()->pluck( 'name', 'id');
            return view('employee.edit', compact('employee', 'offices', 'permissions', 'employeeSchedule'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('update employee'))
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
                'attendance_from' => $request->attendance_from,
                'out_of_office' => $request->out_of_office,
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

            return redirect()->route('employeeIndex')->with('success', 'Employee updated successfully!!');
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Commented in view because of the requirement ie account should be suspended rather than deleting it */
    public function delete($id): RedirectResponse
    {
        if (auth()->user()->hasDirectPermission('delete employee'))
        {
            $employee = User::findOrFail(decrypt($id));

            $permissions = $employee->getAllPermissions();
            $employee->revokePermissionTo($permissions);

            $employee->delete();
            return redirect()->route('employeeIndex')->with('success', __('portal.Employee deleted successfully!!'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function teams()
    {
        if (\auth()->user()->hasRole('admin')){
            $employees = User::with('office')->where('business_id' , \auth()->user()->business_id)->where('parent_id', '!=', 0)->get()->unique('parent_id');
            return view('employee.teams', compact('employees'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function teamEmployeesView($id)
    {
        if (\auth()->user()->hasRole('admin')){
            $employees = User::with('office')->where(['business_id' => \auth()->user()->business_id, 'parent_id' => $id])->orWhere('id', $id)->get()->except(['id' => \auth()->id()]);
            return view('employee.teamEmployees', compact('employees'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Attendance from web */
    public function attendance()
    {
        if (auth()->user()->attendance_from == 1)   /* Default 0 for APP and 1 for WEB */{$attendances = PunchTable::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->get();
            return view('attendance.create', compact('attendances'));
        }
        return redirect()->back()->with('error', __('portal.You do not have permission to mark attendance from web.'));
    }

    public function saveAttendance(Request $request)
    {
        if (auth()->user()->attendance_from == 1) /* Default 0 for APP and 1 for Web  */{
            $validator = Validator::make($request->all(), [
                'type' => 'required',
            ]);

            if ($validator->fails())
            {
                return redirect()->back()->with('error', __('portal.Please try Again.'));
            }

            PunchTable::create([
                'user_id' => auth()->id(),
                'office_id' => auth()->user()->office_id,
                'business_id' => auth()->user()->business_id,
                'mac_address' => substr(shell_exec('getmac'), 159,17),
                'time' => Carbon::now()->format('Y-m-d H:i:s'),
                'in_out_status' => decrypt($request->type),
                'punched_from' => 'Web',
            ]);

            return to_route('attendance.create')->with('success', __('portal.Response send successfully!!!'));
        }
        return back()->with('error' , __('portal.You do not have permission to mark attendance from web.'));
    }

    public function profileEdit(): View
    {
        return view('credentials.edit');
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(),[
            'password' => ['required_with:current_password', 'confirmed',],
            'current_password' => ['required_with:password',],
            'logo' => ['mimes:jpg,bmp,png'],
        ],[
            'password.required_with' => 'New password field is required when current password field is entered',
            'current_password.required_with' => 'Current password field is required when new password field is entered',
            'logo.mimes' => 'Profile Photo must be a file of type: jpg, bmp, png.',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }

        if ($request->password != ''){
            $validator = Validator::make($request->all(),[
                'password' => ['min:8',],
            ]);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator->errors());
            }
        }
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
            if (isset(auth()->user()->profile_photo_path)){
                $image = public_path('storage/'.auth()->user()->profile_photo_path);
                if(File::exists($image)){
                    unlink($image);
                }
            }
            $path = $request->file('logo')->store('', 'public');
            User::where('id', auth()->id())->update(['profile_photo_path' => $path]);
        }

        if ($request->password != ''){
            User::where('id', auth()->id())->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('dashboard')->with('success', __('portal.Profile updated successfully!!'));

    }

    /* Retrieving permissions of the selected role */
    public function permissions(Request $request): JsonResponse
    {
        $permissions = Role::with('permissions')->where('id', $request->role_id)->first()->getAllPermissions()->pluck('name');

        return response()->json(['permissions' => $permissions]);
    }

    /* Same lines of code present in create function so extracted it in a function */
    public function extracted($roles, $offices): View
    {
        $users = User::where('parent_id', auth()->id())->get();
        $authenticatedUser = User::where('id', \auth()->id())->get();
        if ($users) {
            $employees = $users->merge($authenticatedUser);
        }
        else {
            $employees = $authenticatedUser;
        }
        return view('employee.create', compact('roles', 'employees', 'offices'));
    }
}
