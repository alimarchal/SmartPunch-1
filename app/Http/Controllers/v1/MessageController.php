<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        $message = Message::where('user_id_to', auth()->id())->get();
        return response()->json(['messages' => $message]);
    }

    public function unread()
    {
        $message = Message::where(['user_id_to' => auth()->id(), 'read_at' => null])->get();
        return response()->json(['messages' => $message]);
    }

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
}
