<?php

namespace App\Http\Controllers\v1;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\TeamMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function previous()
    {

//        $user_id =  auth()->id();
        $user_id = auth()->id();

        // get user_id_to

        $user_id_to = Message::where('user_id_to',$user_id)->get()->pluck('user_id_from')->toArray();

        $user_id_from = Message::where('user_id_from',$user_id)->get()->pluck('user_id_to')->toArray();

        $array = array_unique(array_merge($user_id_to, $user_id_from));
        sort($array);


        $user_list = User::whereIn('id', $array)->get();

//        return $user_list;
        return response()->json(['messages' => $user_list]);


        /*
        $user = User::select(['id', 'name'])->where('parent_id', auth()->id())->orWhere('id', auth()->id())->get()->pluck('id');

        $previousMessageUserIDs = Message::whereIn('user_id_to', $user)->get()->unique('user_id_to')->pluck('user_id_to');
        $usersWithPreviousMessages = User::select(['id', 'name'])
            ->whereIn('id', $previousMessageUserIDs)
            ->get();
        $receiver = collect();
        $sender = collect();
        */
//        foreach ($usersWithPreviousMessages as $usersWithPreviousMessage) {
//            /* Setting pagination for related relationships */
//            $receiver[] = $usersWithPreviousMessage->receiver()->with('userSend:id,name')->orderByDesc('created_at')->get()->unique('user_id_from');
//            $sender[] = $usersWithPreviousMessage->sender()->with('userReceived:id,name')->orderByDesc('created_at')->get()->unique('user_id_to');
//            $usersWithPreviousMessage['users'] = $receiver->merge($sender);
//        }
//        return response()->json(['messages' => $usersWithPreviousMessages]);
    }

    public function listOfEmployees()
    {
        $employees = User::where('parent_id', auth()->id())->paginate(10);
        return response()->json(['employees' => $employees]);
    }

    /* List of user to send new messages */
    public function newUserMessage()
    {
        $employeeMessages = Message::where('user_id_from', auth()->id())->get()->pluck('user_id_to');
        $users = User::whereNotIn('id', $employeeMessages)->where('parent_id', auth()->id())->paginate(10);
        return response()->json(['users' => $users]);
    }

    ###################### Messages sent to Employees Start ######################
    public function toUser($id)
    {
        $messages = Message::with('userSend:id,name',)->where(['user_id_to' => $id])->orWhere(['user_id_from' => $id])->orderByDesc('created_at')->paginate(10);
        return response()->json(['messages' => $messages]);
    }

        /* Authenticated user Unread Messages */
    public function unread()
    {
        $messages = Message::where(['user_id_to' => auth()->id(), 'read_at' => null])->paginate(10);
        return response()->json(['messages' => $messages]);
    }

        /* Messages to selected employees */
    public function send(Request $request)
    {
        Validator::make($request->all(),[
            'message' => 'required'
        ])->validate();

        foreach ($request->user_ids as $userID){
            $data = [
                'user_id_from' => auth()->id(),
                'user_id_to' => $userID,
                'business_id' => auth()->user()->business_id,
                'office_id' => auth()->user()->office_id,
                'message' => $request->message,
            ];

            $message = Message::create($data);
            $userReceived = $message->userReceived->only(['id', 'name', 'profile_photo_path']);
            event(new NewMessage($message->user_id_from, $message->user_id_to,
                $message->business_id, $message->office_id, $message->message,
                $message->read_at, $message->created_at, $message->updated_at,
                $userReceived
            ));
        }
        return response()->json(['success' => 'Message send.']);
    }
    ###################### Messages sent to Employees End ######################

    ####################### Messages sent to Teams Start #######################
    public function toTeam($id)
    {
        $messages = TeamMessage::where(['team_id' => $id])->paginate(10);
        return response()->json(['messages' => $messages]);
    }

    public function listOfTeams()
    {
        $teams = User::with(['multipleChild'])
            ->where(['business_id' => \auth()->user()->business_id, 'office_id' => auth()->user()->office_id])
            ->get()
            ->unique('parent_id')
            ->except(['id' => \auth()->id()]);
        return response()->json(['teams' => $teams]);
    }

    public function sentToTeams(Request $request)
    {
        $messages = TeamMessage::create([
            'team_id' => $request->team_id,
            'user_id_from' => auth()->user()->id,
            'business_id' => auth()->user()->business_id,
            'office_id' => auth()->user()->office_id,
            'message' => $request->message,
        ]);
//        $messages = TeamMessage::with('userReceived')->where('user_id_from', auth()->user()->id)->orderByDesc('created_at')->paginate(10)->unique('team_id');
        return response()->json(['messages' => 'Message send successfully.'], 200);
    }
    ####################### Messages sent to Teams Start #######################
}
