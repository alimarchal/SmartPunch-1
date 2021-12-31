<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function index(): JsonResponse
    {
        $business = Office::paginate(15);
        return response()->json($business, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): JsonResponse
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'coordinates' => 'required',
            'phone' => 'required',
            'schedule_id' => 'required',
        ],[
            'schedule_id.required' => 'Please select schedule(s)'
        ]);

        $request->merge(['business_id' => auth()->user()->business_id]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $office = Office::create($request->all());

        foreach ($request->schedule_id as $schedule_id)
        {
            OfficeSchedule::create([
                'office_id' => $office->id,
                'schedule_id' => $schedule_id,
            ]);
        }

        if ($office->wasRecentlyCreated) {
            return response()->json($office, 201);
        } else {
            return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
        }
    }

    public function show($id): JsonResponse
    {
        $office = Office::find($id);
        if (!empty($office)) {
            return response()->json($office, 200);
        } else {
            return response()->json(['message' => 'Not Found!'], 404);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id): JsonResponse
    {
        $office = Office::find($id);

        if (empty($office)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
            $office->update($request->all());
            return response()->json($office, 200);
        }
    }

    public function destroy($id): JsonResponse
    {

        $office = Office::find($id);
        if (empty($office)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
            $office = $office->delete();
            return response()->json($office, 200);
        }
    }
}
