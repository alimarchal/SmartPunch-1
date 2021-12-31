<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeSchedule;
use App\Models\Schedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedule = Schedule::paginate(15);
        return response()->json($schedule, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'break_start' => 'required',
            'break_end' => 'required',
            'status' => 'required',
        ],[
            'start_time.required' => 'Start time is required',
            'end_time.required' => 'End time is required',
            'break_start.required' => 'Start time for break is required',
            'break_end.required' => 'Start time for break is required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = [
            'business_id' => auth()->user()->business_id,
            'name' => $request->name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'break_start' => $request->break_start,
            'break_end' => $request->break_end,
            'status' => $request->status,
        ];

        $schedule = Schedule::create($data);
        if ($schedule->wasRecentlyCreated) {
            return response()->json($schedule, 201);
        } else {
            return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
        }
    }

    public function show($id)
    {
        $schedule = Schedule::find($id);
        if (!empty($schedule)) {
            return response()->json($schedule, 200);
        } else {
            return response()->json(['message' => 'Not Found!'], 404);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (empty($schedule)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
            $schedule->update($request->all());
            return response()->json($schedule, 200);
        }
    }

    public function destroy($id)
    {
//        $schedule = Schedule::find($id);
//        if (empty($schedule)) {
//            return response()->json(['message' => 'Not Found!'], 404);
//        } else {
//            $schedule = $schedule->delete();
//            return response()->json($schedule, 200);
//        }
    }

    public function schedules(): JsonResponse
    {
        $schedules = Schedule::with(['officeSchedules', 'officeSchedules.office'])->where('business_id', auth()->user()->business_id)->get();
        return response()->json(['schedules' => $schedules]);
    }
}
