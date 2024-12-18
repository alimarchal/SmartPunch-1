<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Message;
use App\Models\TeamMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    ################# Messages sent to Employees Start #################
    public function toEmployee()
    {
        $employees = User::where(['office_id' => auth()->user()->office_id, 'parent_id' => auth()->id()])
            ->orWhere('id', auth()->user()->parent_id)
            ->get();
        $messages = Message::with('userReceived')->where('user_id_from', auth()->user()->id)->orderByDesc('created_at')->get();
        return view('message.employees', compact('employees', 'messages'));
    }

    public function sendMessageToEmployee(Request $request)
    {
        Validator::make($request->all(), [
            'employeeIDs' => 'required',
            'message' => 'required'
        ],[
            'employeeIDs.required' => __('validation.custom.employeeIDs.required')
        ])->validate();

        foreach ($request->employeeIDs as $employeeID){
            $data = [
                'user_id_from' => auth()->id(),
                'user_id_to' => decrypt($employeeID),
                'business_id' => auth()->user()->business_id,
                'office_id' => auth()->user()->office_id,
                'message' => $request->message,
            ];

//            Message::create($data);
            $message = Message::create($data);
            $userReceived = $message->userReceived->only(['id', 'name', 'profile_photo_path']);
            event(new NewMessage($message->user_id_from, $message->user_id_to,
                $message->business_id, $message->office_id, $message->message,
                $message->read_at, $message->created_at, $message->updated_at,
                $userReceived
            ));
        }
        return to_route('message.toEmployee')->with(['success' => 'Message send successfully!!!']);
    }
    ################# Messages sent to Employees End ###################

    ################## Messages sent to Teams Start ####################
    public function toTeams()
    {
        $employees = User::with(['multipleChild'])
            ->where(['business_id' => \auth()->user()->business_id, 'office_id' => auth()->user()->office_id])
            ->get()
            ->unique('parent_id')
            ->except(['id' => \auth()->id()]);
        return view('message.teams.index', compact('employees'));
    }

    /* Messages send to a team */
    public function byTeams(Request $request)
    {
        $messages = TeamMessage::with('userReceived')->where('team_id', '=','team-'.$request->team_id)->orderByDesc('created_at')->get()->unique('message');
        return view('message.teams.teams', compact( 'messages'));
    }

    public function sendMessageToTeams(Request $request)
    {
        Validator::make($request->all(), [
            'teamIDs' => 'required',
            'message' => 'required'
        ],[
            'teamIDs.required' => __('validation.custom.teamIDs.required')
        ])->validate();

        $users = User::whereIn('parent_id', $request->teamIDs)->get();

        foreach ($users as $user){
            $data = [
                'team_id' => 'team-'.$user->parent_id,
                'user_id_from' => auth()->id(),
                'user_id_to' => $user->id,
                'business_id' => auth()->user()->business_id,
                'office_id' => auth()->user()->office_id,
                'message' => $request->message,
            ];

            TeamMessage::create($data);
        }
        return to_route('message.toTeams')->with(['success' => 'Message send successfully!!!']);
    }

    public function teamEmployeesView($id)
    {
        if (!auth()->user()->hasRole('admin')){
            $employees = User::with('office')->where(['business_id' => \auth()->user()->business_id, 'parent_id' => $id])->get()->except(['id' => \auth()->id()]);
            return view('employee.teamEmployees', compact('employees'));
        }
        return redirect()->route('dashboard')->with('error', __('portal.You do not have permission for this action.'));
    }
    ################## Messages sent to Teams Start ####################
}
