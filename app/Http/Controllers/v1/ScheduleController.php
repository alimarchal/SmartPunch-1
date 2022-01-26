<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchedule;
use App\Models\Office;
use App\Models\OfficeSchedule;
use App\Models\Schedule;
use App\Models\UserHasSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index(): JsonResponse
    {
        $schedules = Schedule::with(['officeSchedules', 'officeSchedules.schedule:id,name', 'officeSchedules.office'])
            ->where('business_id', auth()->user()->business_id)
            ->get();
        return response()->json(['schedules' => $schedules]);
    }

    public function store(StoreSchedule $request): JsonResponse
    {
        $data = [
            'business_id' => auth()->user()->business_id,
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
        ];

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
        if ($schedule->wasRecentlyCreated) {
            return response()->json($schedule, 201);
        } else {
            return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
        }
    }

    public function show(): JsonResponse
    {
        $userSchedule = UserHasSchedule::with('schedule')->firstWhere('user_id', auth()->id());
        if (!empty($userSchedule))
        {
            return response()->json(['schedule' => $userSchedule]);
        }
        else
        {
            return response()->json(['message' => 'Not Found!'], 404);
        }
    }

    public function approve($id): JsonResponse
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update(['status' => 1]);

        return response()->json(['message' => 'Schedule approved successfully!!!', 'schedule' => $schedule]);
    }
}
