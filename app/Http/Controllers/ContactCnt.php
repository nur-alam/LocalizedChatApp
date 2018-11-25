<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactCnt extends Controller
{

    public function get(){

        $contacts = User::where('id', '!=', auth()->id())->get();

        $unreadIdsWithMsgCount = Message::select(DB::raw('`from` as sender_id, count(`from`) as message_count'))
                    ->where('to', auth()->id())
                    ->where('read', false)
                    ->groupBy('from')
                    ->get();

        $contacts = $contacts->map(function ($contact) use ($unreadIdsWithMsgCount){
            $unreadContact = $unreadIdsWithMsgCount->where('sender_id', $contact->id)->first();
            $contact->unread = $unreadContact ? $unreadContact->message_count : 0;
            return $contact;
        });

        return response()->json($contacts);

    }

    public function getMessage($id)
    {
        //$messages = Message::where('from',$id)->Where('to',auth()->id())->get();

        Message::where('from',$id)->where('to', auth()->id())->update(['read' => true]);

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


    public function localizedusers()
    {
        $area = Auth::user()->area;
        $localizedUsers = User::where('area',$area)->where('id',Auth::user()->id)->get();
        return response()->json($localizedUsers);
    }


    public function getPlaces(){
        $loc = base_path().'/places.json';
        $data = file_get_contents($loc);
        return response()->json($data);
    }


}
