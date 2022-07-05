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
        $request->validate([
            'business_id' => 'required',
            'office_id' => 'required',
        ]);
        $task_management = TaskManagment::create($request->all());
        return response()->json($task_management, 200);
    }

    public function show($id)
    {
        $task_management = TaskManagment::find($id);
        return response()->json($task_management, 200);
    }

    public function update(Request $request, TaskManagment $taskManagment)
    {
        $request->validate([
            'business_id' => 'required',
            'office_id' => 'required',
        ]);
        $taskManagment->update($request->all());
        return response()->json($taskManagment, 200);
    }
}
