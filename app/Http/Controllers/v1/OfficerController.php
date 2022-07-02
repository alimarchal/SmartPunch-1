<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeSchedule;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficerController extends Controller
{
    public function index(): JsonResponse
    {

//        dd((auth()->user()->can('permission')));

        if (auth()->user()->can('view office'))
        {
            if (auth()->user()->user_role == 2)     /* 2 for admin*/
            {
                $business = Office::with('officeSchedules', 'officeSchedules.schedule:id,name')->where('business_id', auth()->user()->business_id)->paginate(15);
                return response()->json(['business' => $business]);
            }
            if (auth()->user()->user_role == 3)     /* 3 for Manager*/
            {
                $business = Office::with('officeSchedules', 'officeSchedules.schedule:id,name')->where(['business_id' => auth()->user()->business_id, 'id' => auth()->user()->office_id])->paginate(15);
                return response()->json(['business' => $business]);
            }
        }
        return response()->json(['message' => 'Forbidden!'], 403);
    }

    public function store(Request $request): JsonResponse
    {
        if (auth()->user()->hasDirectPermission('create office'))
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'city' => 'required',
                'inner_coordinates' => 'required',
                'outer_coordinates' => 'required',
                'phone' => 'required',
            ]);

            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()],422);
            }

            $request->merge(['business_id' => auth()->user()->business_id]);

            /* Validating other_city filed and replacing city dropdown value with city name entered in other city text field */
            if ($request->city == 'other'){
                $validator = Validator::make($request->all(), [
                    'other_city' => ['required'],
                ]);
                if ($validator->fails())
                {
                    return response()->json(['errors' => $validator->errors()],422);
                }
                $request->merge(['city' => $request->other_city]);
            }

            $office = Office::create($request->all());

            if (!is_null($request->schedules))
            {
                foreach ($request->schedules as $scheduleID)
                {
                    OfficeSchedule::create([
                        'office_id' => $office->id,
                        'schedule_id' => $scheduleID,
                    ]);
                }
            }

            if ($office->wasRecentlyCreated)
            {
                return response()->json($office, 201);
            }
            else
            {
                return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
            }
        }
        return response()->json(['message' => 'Forbidden!'], 403);
    }

    public function show($id): JsonResponse
    {
        $office = Office::with('officeSchedules', 'officeSchedules.schedule:id,name')->where(['id' => $id, 'business_id' => auth()->user()->business_id])->first();
        if (!empty($office)) {
            return response()->json(['office' => $office]);
        } else {
            return response()->json(['message' => 'Not Found!'], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        if (auth()->user()->hasDirectPermission('update office'))
        {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'address' => ['required', 'max:254'],
                'city' => ['required'],
                'phone' => ['required'],
            ]);

            if ($validator->fails())
            {
                return response()->json(['errors' => $validator->errors()],422);
            }

            $office = Office::where('id', $id)->first();

            /* Validating other_city filed and replacing city dropdown value with city name entered in other city text field */
            if ($request->city == 'other'){
                $validator = Validator::make($request->all(), [
                    'other_city' => ['required'],
                ]);
                if ($validator->fails())
                {
                    return response()->json(['errors' => $validator->errors()],422);
                }
                $request->merge(['city' => $request->other_city]);
            }

            $office->update($request->all());
            $office->save();

            /* Checking whether Requested schedules are not null inorder to prevent office schedules check bypass */
            if (!is_null($request->schedules))
            {
                $officeSchedules = $office->officeSchedules()->whereNotIn('schedule_id', $request->schedules)->get();
            }
            else
            {
                $officeSchedules = $office->officeSchedules()->get();
            }
            $users = collect();
            /* Collecting all users related to the schedules assigned to that office */
            foreach ($officeSchedules as $officeSchedule)
            {
                $userFound = User::where(['office_id' => $officeSchedule->office_id, 'schedule_id' => $officeSchedule->schedule_id])->first();
                if (isset($userFound))
                {
                    $users[] = $userFound;
                }
            }
            /* Collecting all collected users who have assigned schedules for requested office inorder to display error alerts in the view */
            if ($users->count() > 0)
            {
                $assignedSchedules = collect();
                foreach ($users as $user)
                {
                    $userAssignedSchedule = $user->userSchedule()->where('status', 1)->first();
                    $assignedSchedules[] = $userAssignedSchedule->schedule->name;
                }
                return response()->json([
                    'error' => 'Schedule(s) cannot be removed because they are assigned to user(s)',
                    'schedules' => $assignedSchedules
                ],412);
            }

            if (!is_null($request->schedules) || isset($request->schedules)){
                $office->officeSchedules()->whereNotIn('schedule_id', $request->schedules)->delete();
                foreach($request->schedules as $scheduleID)
                {
                    if ($office->officeSchedules->doesntContain('schedule_id', $scheduleID))
                    {
                        OfficeSchedule::create([
                            'office_id' => $office->id,
                            'schedule_id' => $scheduleID,
                        ]);
                    }
                }
            }
            else{
                $office->officeSchedules()->delete();
            }

            return response()->json(['message' => 'Office updated successfully!!']);
        }
        return response()->json(['message' => 'Forbidden!'],403);
    }

    public function delete($id): JsonResponse
    {
        if (auth()->user()->hasDirectPermission('delete office'))
        {
            $office = Office::findOrFail($id);

            if ($office->employees->isNotEmpty())
            {
                return response()->json(['error' => 'Cannot delete because this office has employees assigned to it.'],403);
            }

            $office->officeSchedules()->delete();
            $office->delete();
            return response()->json(['success' => 'Office deleted successfully!!']);
        }
        return response()->json(['message' => 'Forbidden!'],403);
    }

    public function employees($id): JsonResponse
    {
        if (auth()->user()->hasDirectPermission('view office'))
        {
            $office = Office::with('employees', 'employees.userSchedule.schedule')->where('id', $id)->first();
            return response()->json(['office' => $office]);
        }
        return  response()->json(['message' => 'Forbidden'],403);
    }
}
