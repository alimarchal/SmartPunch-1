<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\PunchTable;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $from = Carbon::parse($request->from)->format('Y-m-d');
        $to = Carbon::parse($request->to)->format('Y-m-d');

        $reports = PunchTable::with('office', 'schedule')
            ->where(['user_id' => auth()->id()])
            ->whereDate('created_at', '>=' , $from)
            ->whereDate('created_at', '<=' , $to)
            ->get();

        return response()->json(['reports' => $reports]);
    }

    public function userReport(Request $request): JsonResponse
    {
        $from = Carbon::parse($request->from)->format('Y-m-d');
        $to = Carbon::parse($request->to)->format('Y-m-d');

        $reports = PunchTable::with('office', 'schedule')
            ->where(['user_id' => $request->user_id])
            ->whereDate('created_at', '>=' , $from)
            ->whereDate('created_at', '<=' , $to)
            ->get();

        return response()->json(['reports' => $reports]);
    }

    public function user_id(Request $request)
    {

        if ($request->has('user_id')) {
            $user_id = request('user_id');
            $punch = DB::select("SELECT punch_tables.user_id, punch_tables.office_id, users.name, users.employee_business_id, offices.name as office_name,
                                    SUBSTRING_INDEX(GROUP_CONCAT(CASE WHEN in_out_status='1' THEN time END ORDER BY time ASC),',',1) AS time_in,
                                    SUBSTRING_INDEX(GROUP_CONCAT(CASE WHEN in_out_status='0' THEN time END ORDER BY time ASC),',',-1) AS time_out,
                                    DATE(time) AS punch_date
                                    FROM punch_tables
                                    INNER JOIN users
                                    ON punch_tables.user_id = users.id
                                    INNER JOIN offices
                                    ON punch_tables.office_id = offices.id
                                    WHERE punch_tables.user_id = $user_id
                                    GROUP BY punch_tables.created_at
                                    ORDER BY punch_tables.created_at
                                    ");
            return response()->json(['punch_in_out' => $punch], 200);
        }

        if ($request->has('office_id')) {
            $office_id = request('office_id');
            $punch = DB::select("SELECT punch_tables.user_id, punch_tables.office_id, users.name, users.employee_business_id, offices.name as office_name,
                                    SUBSTRING_INDEX(GROUP_CONCAT(CASE WHEN in_out_status='1' THEN time END ORDER BY time ASC),',',1) AS time_in,
                                    SUBSTRING_INDEX(GROUP_CONCAT(CASE WHEN in_out_status='0' THEN time END ORDER BY time ASC),',',-1) AS time_out,
                                    DATE(time) AS punch_date
                                    FROM punch_tables
                                    INNER JOIN users
                                    ON punch_tables.user_id = users.id
                                    INNER JOIN offices
                                    ON punch_tables.office_id = offices.id
                                    WHERE punch_tables.office_id = $office_id
                                    GROUP BY punch_tables.created_at
                                    ORDER BY punch_tables.created_at
                                    ");
            return response()->json(['punch_in_out' => $punch], 200);
        }

        if ($request->has('business_id')) {
            $business_id = request('business_id');
            $punch = DB::select("SELECT punch_tables.user_id, punch_tables.office_id, users.name, users.employee_business_id, offices.name as office_name,
                                    SUBSTRING_INDEX(GROUP_CONCAT(CASE WHEN in_out_status='1' THEN time END ORDER BY time ASC),',',1) AS time_in,
                                    SUBSTRING_INDEX(GROUP_CONCAT(CASE WHEN in_out_status='0' THEN time END ORDER BY time ASC),',',-1) AS time_out,
                                    DATE(time) AS punch_date
                                    FROM punch_tables
                                    INNER JOIN users
                                    ON punch_tables.user_id = users.id
                                    INNER JOIN offices
                                    ON punch_tables.office_id = offices.id
                                    WHERE punch_tables.business_id = $business_id
                                    GROUP BY punch_tables.created_at
                                    ORDER BY punch_tables.created_at
                                    ");
            return response()->json(['punch_in_out' => $punch], 200);
        }

    }

}
