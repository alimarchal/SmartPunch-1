<?php

namespace App\Http\Controllers;

use App\Models\ScheduleType;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function create()
    {
        return view('schedule.create');
    }

    public function store()
    {
        if(auth()->user()->hasPermissionTo('create schedule'))
        {
            //
        }
    }
}
