<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\PunchTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /* Authenticated user viewing his report */
    public function index(Request $request): JsonResponse
    {
        $from = Carbon::parse($request->from)->format('Y-m-d');
        $to = Carbon::parse($request->to)->format('Y-m-d');

        $reports = PunchTable::with('office:id,name')
            ->where(['user_id' => auth()->id(), 'business_id' => auth()->user()->business_id])
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get()
            ->groupBy(function ($reports) {
                return Carbon::parse($reports->created_at)->format('Y-m-d');
            });

        return response()->json(['reports' => $reports]);
    }

    /* Particular user reports by User ID */
    public function reportByUser(Request $request): JsonResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by user ID'))
        {
            $from = Carbon::parse($request->from)->format('Y-m-d');
            $to = Carbon::parse($request->to)->format('Y-m-d');
            if (auth()->user()->hasRole('admin'))
            {
                if (!isset($request->from) && !isset($request->to)){
                    $reports = PunchTable::with('office:id,name','user:id,name')
                        ->select(['id', 'office_id','user_id', 'time', 'in_out_status', 'created_at'])
                        ->where(['user_id' => $request->user_id, 'business_id' => auth()->user()->business_id])
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->from) && isset($request->to)){
                    $reports = PunchTable::with('office:id,name','user:id,name')
                        ->select(['id', 'office_id','user_id', 'time', 'in_out_status', 'created_at'])
                        ->where(['user_id' => $request->user_id, 'business_id' => auth()->user()->business_id])
                        ->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->from)){
                    $reports = PunchTable::with('office:id,name','user:id,name')
                        ->select(['id', 'office_id','user_id', 'time', 'in_out_status', 'created_at'])
                        ->where(['user_id' => $request->user_id, 'business_id' => auth()->user()->business_id])
                        ->whereDate('created_at', '>=' ,$from)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->to)){
                    $reports = PunchTable::with('office:id,name','user:id,name')
                        ->select(['id', 'office_id','user_id', 'time', 'in_out_status', 'created_at'])
                        ->where(['user_id' => $request->user_id, 'business_id' => auth()->user()->business_id])
                        ->whereDate('created_at', '<=' , $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
            }
            else
            {
                /* Only bringing child records of the login user */
                if (!isset($request->from) && !isset($request->to)){
                    $reports = PunchTable::with('office', 'schedule')
                        ->select(['id', 'office_id','user_id', 'time', 'in_out_status', 'created_at'])
                        ->where(['user_id' => $request->user_id, 'business_id' => auth()->user()->business_id])
                        ->where('office_id', auth()->user()->office_id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->from) && isset($request->to)){
                    $reports = PunchTable::with('office', 'schedule')
                        /*->whereHas('user', function ($query){
                            $query->where('parent_id', auth()->id());
                        })*/
                        ->select(['id', 'office_id','user_id', 'time', 'in_out_status', 'created_at'])
                        ->where(['user_id' => $request->user_id, 'business_id' => auth()->user()->business_id])
                        ->where('office_id', auth()->user()->office_id)
                        ->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->from)){
                    $reports = PunchTable::with('office', 'schedule')
                        ->select(['id', 'office_id','user_id', 'time', 'in_out_status', 'created_at'])
                        ->where(['user_id' => $request->user_id, 'business_id' => auth()->user()->business_id])
                        ->where('office_id', auth()->user()->office_id)
                        ->whereDate('created_at', '>=' ,$from)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->to)){
                    $reports = PunchTable::with('office', 'schedule')
                        ->select(['id', 'office_id','user_id', 'time', 'in_out_status', 'created_at'])
                        ->where(['user_id' => $request->user_id, 'business_id' => auth()->user()->business_id])
                        ->where('office_id', auth()->user()->office_id)
                        ->whereDate('created_at', '<=' , $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
            }
        }

        return response()->json(['Error' => 'Access Forbidden'], 403);
    }

    /* Report by office */
    public function reportByOffice(Request $request): JsonResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by office'))
        {
            $from = Carbon::parse($request->from)->format('Y-m-d');
            $to = Carbon::parse($request->to)->format('Y-m-d');

            if (auth()->user()->hasRole('admin'))
            {
                if (!isset($request->from) && !isset($request->to)){
                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->from) && isset($request->to)){
                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                        ->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->from)){
                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                        ->whereDate('created_at', '>=' ,$from)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->to)){
                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                        ->whereDate('created_at', '<=' ,$to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
            }
            else{
                if (!isset($request->from) && !isset($request->to)){
                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                        ->where('office_id', auth()->user()->office_id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->from) && isset($request->to)){
                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                        ->where('office_id', auth()->user()->office_id)
                        ->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->from)){
                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                        ->where('office_id', auth()->user()->office_id)
                        ->whereDate('created_at', '>=' ,$from)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
                if (isset($request->to)){
                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                        ->where('office_id', auth()->user()->office_id)
                        ->whereDate('created_at', '<=' ,$to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
            }
        }

        return response()->json(['Error' => 'Access Forbidden'], 403);
    }

    /* Report by employee business ID */
    public function reportByEmployeeBusinessID(Request $request): JsonResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by employee business ID'))
        {
            $from = Carbon::parse($request->from)->format('Y-m-d');
            $to = Carbon::parse($request->to)->format('Y-m-d');

            if (auth()->user()->hasRole('admin'))
            {
                $user = User::where(['employee_business_id' => $request->employee_business_id, 'business_id' => auth()->user()->business_id])
                    ->first('id');

                if (!isset($user)){
                    return response()->json(['error' => 'User not found'], 404);
                }

                if (!isset($request->from) && !isset($request->to)){

                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->where('user_id', $user->id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->from) && isset($request->to)){

                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->where('user_id', $user->id)
                        ->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->from)){

                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->where('user_id', $user->id)
                        ->whereDate('created_at', '>=', $from)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->to)){

                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->where('user_id', $user->id)
                        ->whereDate('created_at', '<=', $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($val) {
                            return Carbon::parse($val->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
            }
            else{

                $user = User::where(['employee_business_id' => $request->employee_business_id, 'business_id' => auth()->user()->business_id])
                    ->where('office_id', auth()->user()->office_id)
                    ->first('id');

                if (!isset($user)){
                    return response()->json(['error' => 'User not found'], 404);
                }

                if (!isset($request->from) && !isset($request->to)){

                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                                ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                                ->where('user_id', $user->id)
                                ->orderBy('created_at')
                                ->get()
                                ->groupBy(function ($reports) {
                                    return Carbon::parse($reports->created_at)->format('Y-m-d');
                                });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->from) && isset($request->to)){

                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                                ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                                ->where('user_id', $user->id)
                                ->whereDate('created_at', '>=', $from)
                                ->whereDate('created_at', '<=', $to)
                                ->orderBy('created_at')
                                ->get()
                                ->groupBy(function ($reports) {
                                    return Carbon::parse($reports->created_at)->format('Y-m-d');
                                });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->from)){

                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                                ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                                ->where('user_id', $user->id)
                                ->whereDate('created_at', '>=', $from)
                                ->orderBy('created_at')
                                ->get()
                                ->groupBy(function ($reports) {
                                    return Carbon::parse($reports->created_at)->format('Y-m-d');
                                });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->to)){

                    $reports = PunchTable::with('office:id,name,address', 'user:id,name')
                                ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                                ->where('user_id', $user->id)
                                ->whereDate('created_at', '<=', $to)
                                ->orderBy('created_at')
                                ->get()
                                ->groupBy(function ($reports) {
                                    return Carbon::parse($reports->created_at)->format('Y-m-d');
                                });
                    return response()->json(['reports' => $reports]);
                }
            }
        }

        return response()->json(['Error' => 'Access Forbidden'], 403);
    }

    /* Report by Team */
    public function reportByTeam(Request $request): JsonResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by my team'))
        {
            $from = Carbon::parse($request->from)->format('Y-m-d');
            $to = Carbon::parse($request->to)->format('Y-m-d');

            if (auth()->user()->hasRole('admin')){
                $user = User::where(['parent_id' => $request->parent_id, 'business_id' => auth()->user()->business_id])
                    ->first('id');

                if (!isset($user)){
                    return response()->json(['error' => 'User not found'], 404);
                }

                if (!isset($request->from) && !isset($request->to)){

                    $reports = PunchTable::with(
                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                            $query->select(['id','name','parent_id'])
                                ->where('parent_id', $user->id);
                        }])
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->where('user_id', $user->id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->from) && isset($request->to)){

                    $reports = PunchTable::with(
                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                            $query->select(['id','name','parent_id'])
                                ->where('parent_id', $user->id);
                        }])
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->where('user_id', $user->id)
                        ->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->from)){

                    $reports = PunchTable::with(
                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                            $query->select(['id','name','parent_id'])
                                ->where('parent_id', $user->id);
                        }])
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->whereDate('created_at', '>=', $from)
                        ->where('user_id', $user->id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->to)){

                    $reports = PunchTable::with(
                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                            $query->select(['id','name','parent_id'])
                                ->where('parent_id', $user->id);
                        }])
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->whereDate('created_at', '<=', $to)
                        ->where('user_id', $user->id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
            }
            else{
                $user = User::where(['parent_id' => $request->parent_id, 'business_id' => auth()->user()->business_id])
                    ->where('office_id', auth()->user()->office_id)
                    ->first('id');

                if (!isset($user)){
                    return response()->json(['error' => 'User not found'], 404);
                }

                if (!isset($request->from) && !isset($request->to)){

                    $reports = PunchTable::with(
                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                            $query->select(['id','name','parent_id'])
                                ->where('parent_id', $user->id);
                    }])
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->where('user_id', $user->id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->from) && isset($request->to)){

                    $reports = PunchTable::with(
                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                            $query->select(['id','name','parent_id'])
                                ->where('parent_id', $user->id);
                        }])
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->where('user_id', $user->id)
                        ->whereDate('created_at', '>=', $from)
                        ->whereDate('created_at', '<=', $to)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->from)){

                    $reports = PunchTable::with(
                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                            $query->select(['id','name','parent_id'])
                                ->where('parent_id', $user->id);
                        }])
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->whereDate('created_at', '>=', $from)
                        ->where('user_id', $user->id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }

                if (isset($request->to)){

                    $reports = PunchTable::with(
                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                            $query->select(['id','name','parent_id'])
                                ->where('parent_id', $user->id);
                        }])
                        ->select(['id', 'user_id', 'office_id','time', 'in_out_status', 'created_at'])
                        ->whereDate('created_at', '<=', $to)
                        ->where('user_id', $user->id)
                        ->orderBy('created_at')
                        ->get()
                        ->groupBy(function ($reports) {
                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                        });
                    return response()->json(['reports' => $reports]);
                }
            }
        }

        return response()->json(['Error' => 'Access Forbidden'], 403);
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
