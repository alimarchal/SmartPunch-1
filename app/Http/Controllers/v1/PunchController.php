<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\PunchTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PunchController extends Controller
{
    public function index(): JsonResponse
    {
        $punchInfo = PunchTable::where('user_id', auth()->id())->get();
        return response()->json(['punchInfo' => $punchInfo]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'mac_address' => ['required', 'string', 'max:255'],
            'time' => ['required'],
            'in_out_status' => ['required'],
        ],[
            'mac_address.required' => 'Mac address is required',
            'time.required' => 'Please select a time',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = [
            'user_id' => auth()->id(),
            'office_id' => auth()->user()->office_id,
            'business_id' => auth()->user()->business_id,
            'mac_address' => $request->mac_address,
            'time' => $request->time,
            'in_out_status' => $request->in_out_status,
        ];

        $punched = PunchTable::create($data);

        return response()->json(['message' => 'Data punched successfully!!!', 'punch_data' => $punched]);
    }
}
