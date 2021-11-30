<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\ScheduleType;
use Illuminate\Http\Request;

class ScheduleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedule = ScheduleType::paginate(15);
        return response()->json($schedule, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'business_id' => 'required',
            'office_id' => 'required',
        ]);
        $schedule = ScheduleType::create($request->all());
        if ($schedule->wasRecentlyCreated) {
            return response()->json($schedule, 201);
        } else {
            return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $schedule = ScheduleType::find($id);
        if (!empty($schedule)) {
            return response()->json($schedule, 200);
        } else {
            return response()->json(['message' => 'Not Found!'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $schedule = ScheduleType::find($id);

        if (empty($schedule)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
            $schedule->update($request->all());
            return response()->json($schedule, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = ScheduleType::find($id);
        if (empty($schedule)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
            $schedule = $schedule->delete();
            return response()->json($schedule, 200);
        }
    }
}