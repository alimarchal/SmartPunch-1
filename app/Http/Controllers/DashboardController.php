<?php

namespace App\Http\Controllers;

use App\Models\PunchTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $employees = collect();
        $presentEmployees = collect();      /* For attendance insight graph present in dashboard */
        $absentEmployees = collect();       /* For attendance insight graph present in dashboard */
        if (\auth()->user()->user_role == 2) /* 2 => Admin */
        {
            $employees = User::where('business_id', auth()->user()->business_id)->orderByDesc('created_at')->get()->except([auth()->id()]);
            $presentEmployees = PunchTable::whereIn('user_id', $employees->pluck(['id']))
                                            ->where('in_out_status', 1)
                                            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                            ->orderByDesc('created_at')
                                            ->get();
            $absentEmployees = $employees->whereNotIn('id', $presentEmployees->pluck(['user_id']));
        }
        if (\auth()->user()->user_role == 3) /* 3 => Manager */
        {
            $employees = User::where('business_id', auth()->user()->business_id)->where('user_role', '!=', 2)->orderByDesc('created_at')->get()->except([auth()->id()]);
            $presentEmployees = PunchTable::whereIn('user_id', $employees->pluck(['id']))
                                            ->where('in_out_status', 1)
                                            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                            ->orderByDesc('created_at')
                                            ->get();
            $absentEmployees = $employees->whereNotIn('id', $presentEmployees->pluck(['user_id']));
        }
        if (\auth()->user()->user_role == 4) /* 4 => Supervisor */
        {
            $userRoles = [2,3];
            $employees = User::where('business_id', auth()->user()->business_id)->whereNotIn('user_role', $userRoles)->orderByDesc('created_at')->get()->except([auth()->id()]);
            $presentEmployees = PunchTable::whereIn('user_id', $employees->pluck(['id']))
                                            ->where('in_out_status', 1)
                                            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
                                            ->orderByDesc('created_at')
                                            ->get();
            $absentEmployees = $employees->whereNotIn('id', $presentEmployees->pluck(['user_id']));
        }
        return view('dashboard', compact('employees', 'presentEmployees', 'absentEmployees'));
    }
}
