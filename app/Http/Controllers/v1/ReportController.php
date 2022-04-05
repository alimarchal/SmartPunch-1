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

        $user = User::where(['id' => auth()->id(), 'business_id' => auth()->user()->business_id])
            ->first(['id','name','designation']);

        if (!isset($user) || $user == null){
            return response()->json(['error' => 'User not found'], 404);
        }

        if (!isset($request->from) && !isset($request->to)){

            /* For each user adding attendance information at the end of the user array as par API requirement */
                $userReports[] =  PunchTable::with(
                    ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                        $query->select(['id','name','parent_id'])
                            ->where('parent_id', $user->id);
                    }])
                    ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                    ->where('user_id', $user->id)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function ($reports) {
                        return Carbon::parse($reports->created_at)->format('Y-m-d');
                    });

                /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                $user->attendance = $userReports;

            return response()->json(['reports' => $user]);
        }

        if (isset($request->from) && isset($request->to)){

            /* For each user adding attendance information at the end of the user array as par API requirement */
            $userReports[] =  PunchTable::with(
                ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                    $query->select(['id','name','parent_id'])
                        ->where('parent_id', $user->id);
                }])
                ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                ->where('user_id', $user->id)
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->orderBy('created_at')
                ->get()
                ->groupBy(function ($reports) {
                    return Carbon::parse($reports->created_at)->format('Y-m-d');
                });

            /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
            $user->attendance = $userReports;

            return response()->json(['reports' => $user]);
        }

        if (isset($request->from)){

            /* For each user adding attendance information at the end of the user array as par API requirement */
                $userReports[] =  PunchTable::with(
                    ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                        $query->select(['id','name','parent_id'])
                            ->where('parent_id', $user->id);
                    }])
                    ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                    ->where('user_id', $user->id)
                    ->whereDate('created_at', '>=', $from)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function ($reports) {
                        return Carbon::parse($reports->created_at)->format('Y-m-d');
                    });

                /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                $user->attendance = $userReports;

            return response()->json(['reports' => $user]);
        }

        if (isset($request->to)){

            /* For each user adding attendance information at the end of the user array as par API requirement */
                $userReports[] =  PunchTable::with(
                    ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                        $query->select(['id','name','parent_id'])
                            ->where('parent_id', $user->id);
                    }])
                    ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                    ->where('user_id', $user->id)
                    ->whereDate('created_at', '<=', $to)
                    ->orderBy('created_at')
                    ->get()
                    ->groupBy(function ($reports) {
                        return Carbon::parse($reports->created_at)->format('Y-m-d');
                    });

                /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                $user->attendance = $userReports;

            return response()->json(['reports' => $user]);
        }

        return response()->json(['reports' => $user]);
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
                $users = User::with('office:id,business_id,parent_id,name,address,coordinates')
                            ->select(['id','name','email','office_id','business_id','designation'])
                            ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                            ->get()
                            ->except(['id' => auth()->id()]);

                if (!isset($users) || count($users) == 0){
                    return response()->json(['error' => 'No User Found in this office'], 404);
                }

                if (!isset($request->from) && !isset($request->to)){

                    foreach ($users as $user) {
                        $attendances[] = PunchTable::select(['id','user_id','business_id','time','in_out_status','created_at'])
                                                    ->where(['office_id' => $user->office_id, 'user_id' => $user->id])
                                                    ->orderBy('created_at')
                                                    ->get()
                                                    ->groupBy(function ($val) {
                                                        return Carbon::parse($val->created_at)->format('Y-m-d');
                                                    });

                        /* Appending user attendance to user array */
                        $user->attendance = $attendances;
                        /* Clearing attendance array inorder to prevent previous user data to be added to next user's attendance data */
                        $attendances = array();
                    }

                    return response()->json(['reports' => $users]);
                }
                if (isset($request->from) && isset($request->to)){
                    foreach ($users as $user) {
                        $attendances[] = PunchTable::select(['id','user_id','business_id','time','in_out_status','created_at'])
                                                    ->where(['office_id' => $user->office_id, 'user_id' => $user->id])
                                                    ->whereDate('created_at', '>=', $from)
                                                    ->whereDate('created_at', '<=', $to)
                                                    ->orderBy('created_at')
                                                    ->get()
                                                    ->groupBy(function ($val) {
                                                        return Carbon::parse($val->created_at)->format('Y-m-d');
                                                    });

                        /* Appending user attendance to user array */
                        $user->attendance = $attendances;
                        /* Clearing attendance array inorder to prevent previous user data to be added to next user's attendance data */
                        $attendances = array();
                    }

                    return response()->json(['reports' => $users]);
                }
                if (isset($request->from)){
                    foreach ($users as $user) {
                        $attendances[] = PunchTable::select(['id','user_id','business_id','time','in_out_status','created_at'])
                                                    ->where(['office_id' => $user->office_id, 'user_id' => $user->id])
                                                    ->whereDate('created_at', '>=', $from)
                                                    ->orderBy('created_at')
                                                    ->get()
                                                    ->groupBy(function ($val) {
                                                        return Carbon::parse($val->created_at)->format('Y-m-d');
                                                    });

                        /* Appending user attendance to user array */
                        $user->attendance = $attendances;
                        /* Clearing attendance array inorder to prevent previous user data to be added to next user's attendance data */
                        $attendances = array();
                    }

                    return response()->json(['reports' => $users]);
                }
                if (isset($request->to)){
                    foreach ($users as $user) {
                        $attendances[] = PunchTable::select(['id','user_id','business_id','time','in_out_status','created_at'])
                                                    ->where(['office_id' => $user->office_id, 'user_id' => $user->id])
                                                    ->whereDate('created_at', '<=', $to)
                                                    ->orderBy('created_at')
                                                    ->get()
                                                    ->groupBy(function ($val) {
                                                        return Carbon::parse($val->created_at)->format('Y-m-d');
                                                    });

                        /* Appending user attendance to user array */
                        $user->attendance = $attendances;
                        /* Clearing attendance array inorder to prevent previous user data to be added to next user's attendance data */
                        $attendances = array();
                    }

                    return response()->json(['reports' => $users]);
                }
            }
            else{
                $users = User::with('office:id,business_id,parent_id,name,address,coordinates')
                                    ->select(['id','name','email','office_id','business_id','designation'])
                                    ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                                    ->where('office_id' , auth()->user()->office_id)
                                    ->get()
                                    ->except(['id' => auth()->id()]);

                if (!isset($users) || count($users) == 0){
                    return response()->json(['error' => 'No User Found in this office'], 404);
                }

                if (!isset($request->from) && !isset($request->to)){
                    foreach ($users as $user) {
                        $attendances[] = PunchTable::select(['id','user_id','business_id','time','in_out_status','created_at'])
                                                    ->where(['office_id' => $user->office_id, 'user_id' => $user->id])
                                                    ->orderBy('created_at')
                                                    ->get()
                                                    ->groupBy(function ($val) {
                                                        return Carbon::parse($val->created_at)->format('Y-m-d');
                                                    });

                        $user->attendance = $attendances;

                        $attendances = array();
                    }

                    return response()->json(['reports' => $users]);
                }
                if (isset($request->from) && isset($request->to)){

                    foreach ($users as $user) {
                        $attendances[] = PunchTable::select(['id','user_id','business_id','time','in_out_status','created_at'])
                                                ->where(['office_id' => $user->office_id, 'user_id' => $user->id])
                                                ->whereDate('created_at', '>=', $from)
                                                ->whereDate('created_at', '<=', $to)
                                                ->orderBy('created_at')
                                                ->get()
                                                ->groupBy(function ($val) {
                                                    return Carbon::parse($val->created_at)->format('Y-m-d');
                                                });

                        $user->attendance = $attendances;

                        $attendances = array();
                    }

                    return response()->json(['reports' => $users]);
                }
                if (isset($request->from)){
                    foreach ($users as $user) {
                        $attendances[] = PunchTable::select(['id','user_id','business_id','time','in_out_status','created_at'])
                                                    ->where(['office_id' => $user->office_id, 'user_id' => $user->id])
                                                    ->whereDate('created_at', '>=', $from)
                                                    ->orderBy('created_at')
                                                    ->get()
                                                    ->groupBy(function ($val) {
                                                        return Carbon::parse($val->created_at)->format('Y-m-d');
                                                    });

                        $user->attendance = $attendances;

                        $attendances = array();
                    }

                    return response()->json(['reports' => $users]);
                }
                if (isset($request->to)){
                    foreach ($users as $user) {
                        $attendances[] = PunchTable::select(['id','user_id','business_id','time','in_out_status','created_at'])
                                                    ->where(['office_id' => $user->office_id, 'user_id' => $user->id])
                                                    ->whereDate('created_at', '<=', $to)
                                                    ->orderBy('created_at')
                                                    ->get()
                                                    ->groupBy(function ($val) {
                                                        return Carbon::parse($val->created_at)->format('Y-m-d');
                                                    });

                        $user->attendance = $attendances;

                        $attendances = array();
                    }

                    return response()->json(['reports' => $users]);
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
                $users = User::where(['parent_id' => $request->parent_id, 'business_id' => auth()->user()->business_id])
                            ->get(['id','name','designation']);

                if (!isset($users) || count($users) == 0){
                    return response()->json(['error' => 'User not found'], 404);
                }

                if (!isset($request->from) && !isset($request->to)){

                    /* For each user adding attendance information at the end of the user array as par API requirement */
                    foreach($users as $user){
                        $userReports[] =  PunchTable::with(
                                            ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                                                $query->select(['id','name','parent_id'])
                                                    ->where('parent_id', $user->id);
                                            }])
                                            ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                                            ->where('user_id', $user->id)
                                            ->orderBy('created_at')
                                            ->get()
                                            ->groupBy(function ($reports) {
                                                return Carbon::parse($reports->created_at)->format('Y-m-d');
                                            });

                        /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                        $user->attendance = $userReports;
                        /* Clearing UserReports array because it is adding previous user's data in the array of UserReports */
                        $userReports = array();
                    }

                    return response()->json(['reports' => $users]);
                }

                if (isset($request->from) && isset($request->to)){

                    /* For each user adding attendance information at the end of the user array as par API requirement */
                    foreach($users as $user){
                        $userReports[] =  PunchTable::with(
                                            ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                                                $query->select(['id','name','parent_id'])
                                                    ->where('parent_id', $user->id);
                                            }])
                                            ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                                            ->where('user_id', $user->id)
                                            ->whereDate('created_at', '>=', $from)
                                            ->whereDate('created_at', '<=', $to)
                                            ->orderBy('created_at')
                                            ->get()
                                            ->groupBy(function ($reports) {
                                                return Carbon::parse($reports->created_at)->format('Y-m-d');
                                            });

                        /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                        $user->attendance = $userReports;
                        /* Clearing UserReports array because it is adding previous user's data in the array of UserReports */
                        $userReports = array();
                    }

                    return response()->json(['reports' => $users]);
                }

                if (isset($request->from)){

                    /* For each user adding attendance information at the end of the user array as par API requirement */
                    foreach($users as $user){
                        $userReports[] =  PunchTable::with(
                                            ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                                                $query->select(['id','name','parent_id'])
                                                    ->where('parent_id', $user->id);
                                            }])
                                            ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                                            ->where('user_id', $user->id)
                                            ->whereDate('created_at', '>=', $from)
                                            ->orderBy('created_at')
                                            ->get()
                                            ->groupBy(function ($reports) {
                                                return Carbon::parse($reports->created_at)->format('Y-m-d');
                                            });

                        /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                        $user->attendance = $userReports;
                        /* Clearing UserReports array because it is adding previous user's data in the array of UserReports */
                        $userReports = array();
                    }

                    return response()->json(['reports' => $users]);
                }

                if (isset($request->to)){

                    /* For each user adding attendance information at the end of the user array as par API requirement */
                    foreach($users as $user){
                        $userReports[] =  PunchTable::with(
                                            ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                                                $query->select(['id','name','parent_id'])
                                                    ->where('parent_id', $user->id);
                                            }])
                                            ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                                            ->where('user_id', $user->id)
                                            ->whereDate('created_at', '<=', $to)
                                            ->orderBy('created_at')
                                            ->get()
                                            ->groupBy(function ($reports) {
                                                return Carbon::parse($reports->created_at)->format('Y-m-d');
                                            });

                        /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                        $user->attendance = $userReports;
                        /* Clearing UserReports array because it is adding previous user's data in the array of UserReports */
                        $userReports = array();
                    }

                    return response()->json(['reports' => $users]);
                }
            }
            else{
                $users = User::where(['parent_id' => $request->parent_id, 'business_id' => auth()->user()->business_id])
                            ->where('office_id', auth()->user()->office_id)
                            ->get(['id','name','designation']);

                if (!isset($users) || count($users) == 0){
                    return response()->json(['error' => 'User not found'], 404);
                }

                if (!isset($request->from) && !isset($request->to)){

                    /* For each user adding attendance information at the end of the user array as par API requirement */
                    foreach($users as $user){
                        $userReports[] =  PunchTable::with(
                            ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                                $query->select(['id','name','parent_id'])
                                    ->where('parent_id', $user->id);
                            }])
                            ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                            ->where('user_id', $user->id)
                            ->orderBy('created_at')
                            ->get()
                            ->groupBy(function ($reports) {
                                return Carbon::parse($reports->created_at)->format('Y-m-d');
                            });

                        /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                        $user->attendance = $userReports;
                        /* Clearing UserReports array because it is adding previous user's data in the array of UserReports */
                        $userReports = array();
                    }

                    return response()->json(['reports' => $users]);
                }

                if (isset($request->from) && isset($request->to)){

                    /* For each user adding attendance information at the end of the user array as par API requirement */
                    foreach($users as $user){
                        $userReports[] =  PunchTable::with(
                                        ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                                            $query->select(['id','name','parent_id'])
                                                ->where('parent_id', $user->id);
                                        }])
                                        ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                                        ->where('user_id', $user->id)
                                        ->whereDate('created_at', '>=', $from)
                                        ->whereDate('created_at', '<=', $to)
                                        ->orderBy('created_at')
                                        ->get()
                                        /*->groupBy(['user_id', function ($reports) {
                                            return $reports->user->name;
                                        },function ($reports) {
                                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                                        }]);*/
                                        ->groupBy(function ($reports) {
                                            return Carbon::parse($reports->created_at)->format('Y-m-d');
                                        });

                        /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                        $user->attendance = $userReports;
                        /* Clearing UserReports array because it is adding previous user's data in the array of UserReports */
                        $userReports = array();
                    }
                       /* $reports[] = User::with(['punchTable' => function($query) use($from, $to){
                                        $query->select(['id','user_id','time','in_out_status','created_at'])
                                            ->whereDate('created_at', '>=', $from)
                                            ->whereDate('created_at', '<=', $to)
                                            ->orderBy('created_at')
//                                            ->groupBy('punch_tables.created_at')
//                                            ->groupBy(DB::raw("MONTH(created_at)"))
                                            ->get()
//                                            ->groupBy(['created_at' => function($q){
//                                            return Carbon::parse($q->created_at)->format('Y-m-d');
//                                        }])

                                        ;
                                    }])
                            ->select(['id','name','email', 'designation'])
                            ->where(['parent_id' => $request->parent_id, 'business_id' => auth()->user()->business_id])
                            ->where('office_id', auth()->user()->office_id)
                            ->get()
                            ->groupBy(['id', function ($reports) {
                                return Carbon::parse($reports->created_at)->format('Y-m-d');
                            }]);*/

                    return response()->json(['reports' => $users]);
                }

                if (isset($request->from)){

                    /* For each user adding attendance information at the end of the user array as par API requirement */
                    foreach($users as $user){
                        $userReports[] =  PunchTable::with(
                            ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                                $query->select(['id','name','parent_id'])
                                    ->where('parent_id', $user->id);
                            }])
                            ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                            ->where('user_id', $user->id)
                            ->whereDate('created_at', '>=', $from)
                            ->orderBy('created_at')
                            ->get()
                            ->groupBy(function ($reports) {
                                return Carbon::parse($reports->created_at)->format('Y-m-d');
                            });

                        /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                        $user->attendance = $userReports;
                        /* Clearing UserReports array because it is adding previous user's data in the array of UserReports */
                        $userReports = array();
                    }

                    return response()->json(['reports' => $users]);
                }

                if (isset($request->to)){

                    /* For each user adding attendance information at the end of the user array as par API requirement */
                    foreach($users as $user){
                        $userReports[] =  PunchTable::with(
                            ['office:id,name,address', 'user:id,name', 'user.child' => function($query) use ($user){
                                $query->select(['id','name','parent_id'])
                                    ->where('parent_id', $user->id);
                            }])
                            ->select(['id', 'user_id','office_id','time', 'in_out_status', 'created_at'])
                            ->where('user_id', $user->id)
                            ->whereDate('created_at', '<=', $to)
                            ->orderBy('created_at')
                            ->get()
                            ->groupBy(function ($reports) {
                                return Carbon::parse($reports->created_at)->format('Y-m-d');
                            });

                        /* Adding attendance variable at the end of the user's array containing attendance of that user by dates */
                        $user->attendance = $userReports;
                        /* Clearing UserReports array because it is adding previous user's data in the array of UserReports */
                        $userReports = array();
                    }

                    return response()->json(['reports' => $users]);
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
