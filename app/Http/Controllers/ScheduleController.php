<?php

namespace App\Http\Controllers;

use App\Models\ScheduleType;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function create()
    {
        $scheduleTypes = ScheduleType::all();
        return view('schedule.create', compact('scheduleTypes'));
    }

    public function store()
    {
        if(auth()->user()->hasPermissionTo('create schedule'))
        {
            //
        }
    }
}
