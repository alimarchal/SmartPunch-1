<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\TaskManagment;
use Illuminate\Http\Request;

class TaskManagmentController extends Controller
{

    public function index(Request $request)
    {
        $task_management = TaskManagment::paginate(10);
        return response()->json($task_management, 200);
    }

    public function store(Request $request)
    {

        $task_management = TaskManagment::create([
            'task_name' => $request->task_name,
            'task_progress' => $request->task_progress,
            'business_id' => auth()->user()->business_id,
            'office_id' => auth()->user()->office_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'actual_task_completion_date' => $request->actual_task_completion_date,
            'assign_to' => $request->assign_to,
            'assign_from' => auth()->user()->name,
            'from_the_assigner' => $request->from_the_assigner,
            'from_the_assignee' => $request->from_the_assignee,
        ]);
        return response()->json($task_management, 200);
    }

    public function show($id)
    {
        $task_management = TaskManagment::find($id);
        return response()->json($task_management, 200);
    }

    public function update(Request $request, TaskManagment $taskManagment)
    {
        $taskManagment->update();
        return response()->json($taskManagment, 200);
    }
}
