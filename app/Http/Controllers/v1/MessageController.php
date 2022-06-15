<?php

namespace App\Http\Controllers\v1;

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
        /*$message = User::with(['receiver' => function($query){
            $query->select(['id', 'user_id_from', 'user_id_to', 'message', 'read_at', 'created_at'])
                ->where('user_id_from', auth()->id());
        }])
            ->select(['id', 'name'])
            ->where('parent_id', auth()->id())->get();
        return response()->json(['messages' => $message]);*/

        /*$user = User::select(['id', 'name'])->where('parent_id', auth()->id())->orWhere('id', auth()->id())->get()->pluck('id');
        $previousMessageUserIDs = Message::whereIn('user_id_to', $user)->get()->unique('user_id_to')->pluck('user_id_to');
        $usersWithPreviousMessages = User::with(['receiver' => function ($query) {
            $query->select(['id', 'user_id_from', 'user_id_to', 'message', 'read_at', 'created_at'])
                ->where(function ($query){
                    $query->where('user_id_from', auth()->id());
                    $query->orWhere('user_id_to', auth()->id());
                })
            ;
        }])
            ->select(['id', 'name'])
            ->whereIn('id', $previousMessageUserIDs)->get();*/

        $user = User::select(['id', 'name'])->where('parent_id', auth()->id())->orWhere('id', auth()->id())->get()->pluck('id');
        $previousMessageUserIDs = Message::whereIn('user_id_to', $user)->get()->unique('user_id_to')->pluck('user_id_to');
        $usersWithPreviousMessages = User::with(['receiver' => function ($query) {
            $query->select(['id', 'user_id_from', 'user_id_to', 'message', 'read_at', 'created_at']);
        }, 'sender' => function ($query) {
            $query->select(['id', 'user_id_from', 'user_id_to', 'message', 'read_at', 'created_at']);
        }])
            ->select(['id', 'name'])
            ->whereIn('id', $previousMessageUserIDs)
            ->get();
        $sender = collect();
        foreach ($usersWithPreviousMessages as $usersWithPreviousMessage) {
            /* Setting pagination for related relationships */
            foreach ($usersWithPreviousMessage->receiver as $receiver){
                $sender[] = $receiver->userSend->only(['id', 'name', 'profile_photo_url']);
            }
            $usersWithPreviousMessage['senderUsers'] = $sender->unique(['id']);
            $usersWithPreviousMessage->setRelation('receiver', $usersWithPreviousMessage->receiver()->paginate(10));
            $usersWithPreviousMessage->setRelation('sender', $usersWithPreviousMessage->sender()->paginate(10));
        }
        return response()->json(['messages' => $usersWithPreviousMessages]);
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
        $messages = Message::where(['user_id_to' => $id, 'read_at' => null])->paginate(10);
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

            Message::create($data);
        }
        return response()->json(['success' => 'Message send.']);
    }
    ###################### Messages sent to Employees End ######################

    ####################### Messages sent to Teams Start #######################
    public function toTeam($id)
    {
        $messages = TeamMessage::where(['team_id' => $id, 'read_at' => null])->paginate(10)->unique('message');
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

    public function sentToTeams()
    {
        $messages = TeamMessage::with('userReceived')->where('user_id_from', auth()->user()->id)->orderByDesc('created_at')->paginate(10)->unique('team_id');
        return response()->json(['messages' => $messages]);
    }
    ####################### Messages sent to Teams Start #######################
}
