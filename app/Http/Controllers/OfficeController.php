<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\OfficeSchedule;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    public function index()
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

    public function create()
    {
        if (auth()->user()->hasPermissionTo('create office'))
        {
            $schedules = Schedule::where(['business_id' => auth()->user()->business_id, 'status' => 1])->get();
            return view('office.create', compact('schedules'));
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
            ])->validate();

            $data = [
                'business_id' => auth()->user()->business->id,
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'coordinates' => $request->coordinates,
            ];

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

            return redirect()->route('officeIndex')->with('success', 'Office added successfully!');
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function edit($id)
    {
        if (auth()->user()->hasPermissionTo('update office'))
        {
            $office = Office::with('business', 'officeSchedules.schedule')->where('id', decrypt($id))->first();
            $schedules = Schedule::where('business_id', auth()->user()->business_id)->get();
            return view('office.edit', compact('office', 'schedules'));
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

            $office->update($request->all());
            $office->save();

//            $office->officeSchedules()->update([$office->officeSchedules]);

            return redirect()->route('officeIndex')->with('success', 'Office updated successfully!!');
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

    }

    public function employees($id)
    {
        if (auth()->user()->hasPermissionTo('view office'))
        {
            $office = Office::with('employees')->where('id', decrypt($id))->first();
            return view('office.employeeList', compact('office'));
        }
        return  redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function schedules(Request $request): JsonResponse
    {
        $officeSchedules = OfficeSchedule::with('schedule')->where('office_id', $request->office_id)->get();
        $scheduleIDs = array();
        foreach ($officeSchedules as $officeSchedule)
        {
            $scheduleIDs[] = $officeSchedule->schedule->id;
        }
        $schedules = Schedule::whereIn('id', $scheduleIDs)->where('status', 1)->get();

        return response()->json(['schedules' => $schedules]);
    }
}
