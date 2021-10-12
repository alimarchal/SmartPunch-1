<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\PunchTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\PunchTable $punchTable
     * @return \Illuminate\Http\Response
     */
    public function show(PunchTable $punchTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PunchTable $punchTable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PunchTable $punchTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\PunchTable $punchTable
     * @return \Illuminate\Http\Response
     */
    public function destroy(PunchTable $punchTable)
    {
        //
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

    }
}
