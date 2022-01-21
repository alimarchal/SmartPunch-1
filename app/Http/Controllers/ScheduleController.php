<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchedule;
use App\Models\Office;
use App\Models\OfficeSchedule;
use App\Models\Schedule;
use App\Models\UserHasSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('officeSchedules.office')->where('business_id', auth()->user()->business_id)->get();
        return view('schedule.index', compact('schedules'));
    }

    public function create()
    {
        $offices = Office::where('business_id', auth()->user()->business_id)->get();
        return view('schedule.create', compact('offices'));
    }

    public function store(StoreSchedule $request): RedirectResponse
    {
        if(auth()->user()->hasPermissionTo('create schedule'))
        {
            $data = [
                'business_id' => auth()->user()->business_id,
                'name' => $request->name,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'break_start' => $request->break_start,
                'break_end' => $request->break_end,
            ];
            if (auth()->user()->hasRole('admin'))
            {
                $data = [
                    'business_id' => auth()->user()->business_id,
                    'name' => $request->name,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'break_start' => $request->break_start,
                    'break_end' => $request->break_end,
                    'status' => 1,
                ];
            }
            $schedule = Schedule::create($data);
            if (!is_null($request->offices))
            {
                foreach ($request->offices as $officeID)
                {
                    OfficeSchedule::create([
                        'office_id' => $officeID,
                        'schedule_id' => $schedule->id,
                    ]);
                }
            }

            return redirect()->route('scheduleIndex')->with('success', __('portal.Schedule added successfully!!!'));
        }
        return redirect()->back()->with('error', __('portal.You do not have permission for this action.'));
    }

    public function show()
    {
        $userSchedule = UserHasSchedule::with('schedule')->firstWhere('user_id', auth()->id());
        return view('schedule.show', compact('userSchedule'));
    }

    public function approve(Request $request): JsonResponse
    {
        $schedule = Schedule::where('id', $request->id)->first();

        if (!$schedule)
        {
            return response()->json( ['status' => 0]);
        }

        $schedule->update(['status' => 1]);

        return response()->json( ['status' => 1]);
    }
}
