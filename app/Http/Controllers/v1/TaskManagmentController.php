<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\TaskManagment;
use Illuminate\Http\Request;

class TaskManagmentController extends Controller
{
    //

    public function index(Request $request)
    {
        $task_management = TaskManagment::paginate(10);
        return response()->json($task_management, 200);
    }



    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'task_progress' => 'required',
            'business_id' => 'required',
            'office_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'assign_to' => 'required',
            'assign_from' => 'required',
            'comment' => 'required',
        ]);
        $task_management = TaskManagment::create($request->all());
        return response()->json($task_management, 200);
    }
}
