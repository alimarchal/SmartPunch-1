<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
