<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Office;
use App\Models\OfficeSchedule;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserHasSchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Collection;
use function PHPUnit\Framework\isNull;

class OfficeController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('view office'))
        {
            if (auth()->user()->user_role == 2)     /* 2 for admin*/
            {
                $offices = Office::with('business', 'officeSchedules.schedule')
                                ->where('business_id', auth()->user()->business_id)
                                ->get();

                return view('office.index', compact('offices'));
            }
            if (auth()->user()->user_role == 3)     /* 3 for Manager*/
            {
                $offices = Office::with('business', 'officeSchedules.schedule')
                                ->where(['business_id' => auth()->user()->business_id, 'id' => auth()->user()->office_id])
                                ->get();

                return view('office.index', compact('offices'));
            }
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function create(): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('create office'))
        {
            $cities = City::where('country_id', auth()->user()->business->country_name['id'])->get();
            $citiesJson = $cities->map(function ($city) { return $city->name;})->toJson();
            $schedules = Schedule::where(['business_id' => auth()->user()->business_id, 'status' => 1])->get();
            return view('office.create', compact('schedules', 'cities', 'citiesJson'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('create office'))
        {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'address' => ['required', 'max:254'],
                'city' => ['required'],
                'phone' => ['required'],
                'outer_coordinates' => Rule::requiredIf($request->inner_coordinates != null),
            ])->validate();

            $data = [
                'business_id' => auth()->user()->business->id,
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'inner_coordinates' => $request->inner_coordinates,
                'outer_coordinates' => $request->outer_coordinates,
            ];

            /* Validating other_city filed and replacing city dropdown value with city name entered in other city text field */
            if ($request->city == 'other'){
                Validator::make($request->all(), [
                    'other_city' => ['required'],
                ])->validate();
                $data['city'] = $request->other_city;
            }

            $office = Office::create($data);

            if (!is_null($request->schedules))
            {
                foreach ($request->schedules as $scheduleID)
                {
                    OfficeSchedule::create([
                        'office_id' => $office->id,
                        'schedule_id' => $scheduleID,
                    ]);
                }
            }

            return redirect()->route('officeIndex')->with('success', __('portal.Office added successfully!!!'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function edit($id): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('update office'))
        {
            $cities = City::where('country_id', auth()->user()->business->country_name['id'])->get();
            $citiesJson = $cities->map(function ($city) { return $city->name;})->toJson();

            $office = Office::with('business', 'officeSchedules.schedule')->where('id', decrypt($id))->first();
            $schedules = Schedule::where(['business_id' => auth()->user()->business_id, 'status' => 1])->get();
            return view('office.edit', compact('office', 'schedules', 'cities', 'citiesJson'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('update office'))
        {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'address' => ['required', 'max:254'],
                'city' => ['required'],
                'phone' => ['required'],
            ])->validate();

            $office = Office::where('id', decrypt($id))->first();

            /* Validating other_city filed and replacing city dropdown value with city name entered in other city text field */
            if ($request->city == 'other'){
                Validator::make($request->all(), [
                    'other_city' => ['required'],
                ])->validate();
                $request->merge(['city' => $request->other_city]);
            }

            $office->update($request->all());
            $office->save();

            /* Checking whether Requested schedules are not null inorder to prevent office schedules check bypass */
            if (!is_null($request->schedules))
            {
                $officeSchedules = $office->officeSchedules()->whereNotIn('schedule_id', $request->schedules)->get();
            }
            else
            {
                $officeSchedules = $office->officeSchedules()->get();
            }
            $users = collect();
            /* Collecting all users related to the schedules assigned to that office */
            foreach ($officeSchedules as $officeSchedule)
            {
                $userFound = User::where(['office_id' => $officeSchedule->office_id, 'schedule_id' => $officeSchedule->schedule_id])->first();
                if (isset($userFound))
                {
                    $users[] = $userFound;
                }
            }
            /* Collecting all collected users who have assigned schedules for requested office inorder to display error alerts in the view */
            if ($users->count() > 0)
            {
                $assignedSchedules = collect();
                foreach ($users as $user)
                {
                    $userAssignedSchedule = $user->userSchedule()->where('status', 1)->first();
                    $assignedSchedules[] = $userAssignedSchedule->schedule->name;
                }
                session()->flash('assignedSchedules', $assignedSchedules);
                return redirect()->back()->with('error', 'Schedule(s) cannot be removed because they are assigned to user(s)');
            }

            if (!is_null($request->schedules) || isset($request->schedules)){
                $office->officeSchedules()->whereNotIn('schedule_id', $request->schedules)->delete();
                foreach($request->schedules as $scheduleID)
                {
                    if ($office->officeSchedules->doesntContain('schedule_id', $scheduleID))
                    {
                        OfficeSchedule::create([
                            'office_id' => $office->id,
                            'schedule_id' => $scheduleID,
                        ]);
                    }
                }
            }
            else{
                $office->officeSchedules()->delete();
            }

            return redirect()->route('officeIndex')->with('success', __('portal.Office updated successfully!!'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function delete($id)
    {
        if (auth()->user()->hasPermissionTo('delete office'))
        {
            $office = Office::findOrFail(decrypt($id));

            if ($office->employees->isNotEmpty())
            {
                return redirect()->back()->with('error', __('portal.Cannot delete because this office has employees assigned to it.'));
            }

            $office->delete();
            return redirect()->route('officeIndex')->with('success', __('portal.Office deleted successfully!!'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function employees($id): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('view office'))
        {
            $office = Office::with('employees', 'employees.userSchedule.schedule')->where('id', decrypt($id))->first();
            return view('office.employeeList', compact('office'));
        }
        return  redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Response to API present in Employee Create view */
    public function schedules(Request $request): JsonResponse
    {
        $officeSchedules = OfficeSchedule::with('schedule')->where('office_id', $request->office_id)->get();
        $scheduleIDs = array();
        foreach ($officeSchedules as $officeSchedule)
        {
            $scheduleIDs[] = $officeSchedule->schedule->id;
        }
        $schedules = Schedule::whereIn('id', $scheduleIDs)->where('status', 1)->get();

        $officeEmployees = User::where('office_id', $request->office_id)->get();

        return response()->json(['schedules' => $schedules, 'officeEmployees' => $officeEmployees]);
    }
}
