<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\PunchTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasPermissionTo('view reports'))
        {
            if (\auth()->user()->user_role == 2) /* 2 => Admin */
            {
                $employees = User::with(['userOffice' => function($query){
                    $query->where('status', 1);
                }], ['userSchedule' => function($query){
                    $query->where('status', 1);
                }])
                    ->where('business_id', auth()->user()->business_id)
                    ->orderByDesc('created_at')
                    ->get()
                    ->except(auth()->id());
                return view('reports.index', compact('employees'));
            }
            if (\auth()->user()->user_role == 3) /* 3 => Manager */{}
            if (\auth()->user()->user_role == 5) /* 4 => Employee */{}
        }
    }

    public function byOfficeView(): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by office')){
            if (auth()->user()->hasRole('admin')){
                $offices = Office::where('business_id', auth()->user()->business_id)->get();
                $attendances = collect();

                return view('reports.byOffice.index', compact('offices', 'attendances'));
            }
            else{
                $offices = Office::where(['id' => auth()->user()->office_id, 'business_id' => auth()->user()->business_id])->get();
                $attendances = collect();

                return view('reports.byOffice.index', compact('offices', 'attendances'));
            }
        }

        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function byOfficeID(Request $request): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by office')){
            if (auth()->user()->hasRole('admin')){
                $currentDate = Carbon::parse(Carbon::now())->format('Y-m-d');

                $offices = Office::where('business_id', auth()->user()->business_id)->get();
                /*$reports = PunchTable::with('office:id,name,address')
                    ->with('user:id,name')
                    ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                    ->whereDate('created_at', '=' , $currentDate)
                    ->get()
                    ->groupBy('user_id');*/

                $attendances = DB::table('punch_tables')->select('punch_tables.id', 'punch_tables.user_id', 'users.name',
                    DB::raw('GROUP_CONCAT(punch_tables.in_out_status, "-", punch_tables.time) as time'))
                    ->join('users', 'users.id', '=','punch_tables.user_id')
                    ->where(['punch_tables.office_id' => decrypt($request->office_id), 'punch_tables.business_id' => auth()->user()->business_id])
                    ->whereDate('punch_tables.created_at', '=' , $currentDate)
                    ->groupBy('punch_tables.user_id')
                    ->get()
//                    ->map(function ($attendances) {
//                        $in_out = explode(', ', $attendances->time);
//                        foreach ($in_out as $item) {
//                            [$key, $value] = explode('-', $item);
//                            $attendances->{$key} = $item;
////                            $attendances[$key] = $item;
//                        }
//                        return $attendances;
//                    })
                ;
//dd($attendances);
                /* Below variable used in view inorder to show which office is selected */
                $sentOffice = Office::firstWhere(['id' => decrypt($request->office_id), 'business_id' => auth()->user()->business_id]);

                return view('reports.byOffice.index', compact('offices', 'sentOffice', 'attendances'));
            }
            else{
                $currentDate = Carbon::parse(Carbon::now())->format('Y-m-d');

                $offices = Office::where(['id' => auth()->user()->office_id, 'business_id' => auth()->user()->business_id])->get();
                /*$reports = PunchTable::with('office:id,name,address')
                    ->with('user:id,name')
                    ->where(['office_id' => $request->office_id, 'business_id' => auth()->user()->business_id])
                    ->whereDate('created_at', '=' , $currentDate)
                    ->get()
                    ->groupBy('user_id');*/

                $attendances = DB::table('punch_tables')->select('punch_tables.id', 'punch_tables.user_id', 'users.name',
                    DB::raw('GROUP_CONCAT(punch_tables.in_out_status, "-", punch_tables.time) as time'))
                    ->join('users', 'users.id', '=','punch_tables.user_id')
                    ->where(['punch_tables.office_id' => decrypt($request->office_id), 'punch_tables.business_id' => auth()->user()->business_id])
                    ->where('users.id', '!=', auth()->id() )
                    ->whereDate('punch_tables.created_at', '=' , $currentDate)
                    ->groupBy('punch_tables.user_id')
                    ->get()
//                    ->map(function ($attendances) {
//                        $in_out = explode(', ', $attendances->time);
//                        foreach ($in_out as $item) {
//                            [$key, $value] = explode('-', $item);
//                            $attendances->{$key} = $item;
////                            $attendances[$key] = $item;
//                        }
//                        return $attendances;
//                    })
                ;
//dd($attendances);
                /* Below variable used in view inorder to show which office is selected */
                $sentOffice = Office::firstWhere(['id' => decrypt($request->office_id), 'business_id' => auth()->user()->business_id]);

                return view('reports.byOffice.index', compact('offices', 'sentOffice', 'attendances'));
            }
        }

        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function byEmployeeBusinessIDView(): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by employee business ID')){
            if (auth()->user()->hasRole('admin')){
                $employees = User::where('business_id', auth()->user()->business_id)
                    ->where('employee_business_id', '!=', null)
                    ->get()
                    ->except([auth()->id()]);
            }
            else{
                $employees = User::where(['office_id' => auth()->user()->office_id, 'business_id' => auth()->user()->business_id])
                    ->where('employee_business_id', '!=', null)
                    ->get()
                    ->except([auth()->id()]);
            }
            $reports = collect();

            return view('reports.byEmployeeBusinessID.index', compact('employees', 'reports'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function byEmployeeBusinessID(Request $request): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by employee business ID')){
            $currentDate = Carbon::parse(Carbon::now())->format('Y-m-d');
            if (auth()->user()->hasRole('admin')){

                $employees = User::where('business_id', auth()->user()->business_id)
                    ->where('employee_business_id', '!=', null)
                    ->get()
                    ->except([auth()->id()]);

                /* Below variable used in view inorder to show which employee is selected */
                $sentEmployee = User::firstWhere(['id' => decrypt($request->employee_id), 'business_id' => auth()->user()->business_id]);

            }
            else{

                $employees = User::where(['office_id' => auth()->user()->office_id, 'business_id' => auth()->user()->business_id])
                    ->where('employee_business_id', '!=', null)
                    ->get()
                    ->except([auth()->id()]);

                /* Below variable used in view inorder to show which employee is selected */
                $sentEmployee = User::where(['id' => decrypt($request->employee_id), 'business_id' => auth()->user()->business_id])
                    ->where('office_id', auth()->user()->office_id)
                    ->first();

            }
            $reports = PunchTable::with('office:id,name,address')
                ->with('user:id,name')
                ->where(['user_id' => $sentEmployee->id, 'business_id' => auth()->user()->business_id])
                ->whereDate('created_at', '=' , $currentDate)
                ->get();
//dd(last($reports));
//dd($reports[count($reports) - 1]->in_out_status);
            return view('reports.byEmployeeBusinessID.index', compact('employees', 'reports', 'sentEmployee'));
        }

        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    public function byEmployeeBusinessIDShow($id)
    {
        if (auth()->user()->hasPermissionTo('view reports by employee business ID')){
            $currentDate = Carbon::parse(Carbon::now())->format('Y-m-d');
            if (auth()->user()->hasRole('admin')){

                $employees = User::where('business_id', auth()->user()->business_id)
                    ->where('employee_business_id', '!=', null)
                    ->get()
                    ->except([auth()->id()]);

                $reports = PunchTable::with('office:id,name,address')
                    ->with('user:id,name')
                    ->where(['user_id' => $id, 'business_id' => auth()->user()->business_id])
                    ->whereDate('created_at', '=' , $currentDate)
                    ->get();


                /* Below variable used in view inorder to show which employee is selected */
                $sentEmployee = User::firstWhere(['id' => $id, 'business_id' => auth()->user()->business_id]);

            }
            else{
                $employees = User::where(['office_id' => auth()->user()->office_id,'business_id' => auth()->user()->business_id])
                    ->where('employee_business_id', '!=', null)
                    ->get()
                    ->except([auth()->id()]);

                /* Below variable used in view inorder to show which employee is selected */
                $sentEmployee = User::where(['id' => $id, 'business_id' => auth()->user()->business_id])
                    ->where('office_id', auth()->user()->office_id)
                    ->first();

            }
            $reports = PunchTable::with('office:id,name,address')
                                ->with('user:id,name')
                                ->where(['user_id' => $id, 'business_id' => auth()->user()->business_id])
                                ->whereDate('created_at', '=' , $currentDate)
                                ->get();

            return view('reports.byEmployeeBusinessID.byID', compact('employees','reports', 'sentEmployee'));
        }

        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }

    /* Report by Team */
    public function reportByTeam(Request $request): View|RedirectResponse
    {
        if (auth()->user()->hasPermissionTo('view reports by my team'))
        {
            if (auth()->user()->hasRole('admin')){
                $teams = User::with(['punchTable' => function($query){
                    $query->whereDate('created_at', '=', Carbon::parse(Carbon::now())->format('Y-m-d'));
                }])
                    ->with('child:id,name,parent_id')
                    ->select(['id','name','email'])
                    ->where(['parent_id' => auth()->id(), 'business_id' => auth()->user()->business_id])
                    ->get();
            }
            else{
                $teams = User::with(['punchTable' => function($query){
                    $query->whereDate('created_at', '=', Carbon::parse(Carbon::now())->format('Y-m-d'));
                }])
                    ->with('child:id,name,parent_id')
                    ->select(['id','name','email'])
                    ->where(['parent_id' => $request->parent_id, 'business_id' => auth()->user()->business_id])
                    ->where('office_id', auth()->user()->office_id)
                    ->get();
            }

            return view('reports.byTeam.index', compact('teams'));
        }

        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }
}
