<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Message;
use App\User;
use Illuminate\Http\Request;

class ContactCnt extends Controller
{
    public function get(){
        $contacts = User::where('id', '!=', auth()->id())->get();
        return response()->json($contacts);
    }
//$users = DB::table('users')->where([
//['status', '=', '1'],
//['subscribed', '<>', '1'],
//])->get();
    public function getMessage($id)
    {
        //$messages = Message::where('from',$id)->Where('to',auth()->id())->get();
        $messages = Message::where([
                            ['from','=',$id],
                            ['to','=',auth()->id()]
                        ])->orWhere([
                            ['from' , '=', auth()->id()],
                            ['to' , '=', $id]
                        ])->get();
        return response()->json($messages);
    }

    public function sendMsg(Request $request)
    {

//        $message = Message::create([
//            'from' => auth()->id(),
//            'to' => $request->contact_id,
//            'text' => $request->text
//        ]);

        $message = new Message;

        $message->from = auth()->id();
        $message->to = $request->contact_id;
        $message->text = $request->text;

        if($message->save()){
            broadcast(new NewMessage($message));
            return response()->json($message);
        }

        //return response()->json($message);

       // return response()->json(['err'=>'failed to save message']);


    }

}
