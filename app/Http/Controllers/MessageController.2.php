<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Matching;
use App\Profil;
use App\Message;
use App\Traits\my_traits;

class MessageController extends Controller
{

    // ----
    use my_traits; // This is an important line for the trait to be loaded
    // ----

    public function index($id1, $id2){     

        // Check id1 corresponds to the logged user
        $logged_id = auth()->user()->profile->id;
        if(($id1!=$logged_id) || ($id1==$logged_id && $id2==$logged_id)){
            return redirect()->route('get_profile', auth()->user()->profile->id)->with("error", 'Unauthorized action!');
        }

        // Get profil of the second user
        $second_user = Profil::find($id2);

        // Check if the id2 is of opposite sex
        if(auth()->user()->profile->sex_id == $second_user->sex_id){
            return redirect()->route('my_profile')->with("error", 'Unauthorized action!');        
        }

        // Get the messages
        $messages=Message::where(function($query) use($id2){
            $query->where('user_1', auth()->user()->profile->id)
                ->where('user_2', $id2);
        })        
        ->orWhere(function($query1) use($id2){
            $query1->where('user_2', auth()->user()->profile->id)
            ->where('user_1', $id2);
        })->orderBy('created_at')->get();

        
        // Since we access the messages then the 'seen' field of the unread messages has to be changed to 1
        \DB::table('messages')->where('user_2','=', auth()->user()->profile->id)
                            ->where('user_1', $id2)
                            ->update(['seen'=>1]);

        

        

        // Get the name of the person to chat with
        $second_user=Profil::find($id2);

        // Check if the 2 users are still matched
        $me_matched = Matching::where('user_1','=',auth()->user()->profile->id)
                ->where('user_2', $id2)->first(); 
        $other_matched = Matching::where('user_2','=',auth()->user()->profile->id)
                ->where('user_1', $id2)->first();

        $still_matched = null;
        if(!is_null($me_matched) && !is_null($other_matched)){
            $still_matched = 1;
        }        

        $profile = \DB::table('users')
            ->where('status_id', '=', 3) 
            ->join('profils', 'profils.user_id', '=', 'users.id')
            ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
            ->where('pictures.is_main', '=', 1) 
            ->where('profils.id', $id2)             
            ->select('profils.id','users.name','picture','birthday', 'status_id')->first();
        
        

        $contacts = $this->my_discussions(auth()->user()->profile->id);
        dd($contacts);

        return view('messages.messages')->with([
                                                'profile'=>$profile,
                                                "messages"=> $messages, 
                                                'second_user'=>$second_user,
                                                'still_matched'=>$still_matched]);


    }
    
    public function my_discussions($id){
        
        // Get users that I have sent messages to (just in case they didn't answer)
        // $me_sending = Message::where('user_1', auth()->user()->profile->id)->pluck("user_2")->toArray();
        // // Get users sent me messages (just in case I didn't answer)
        // $send_me =  Message::where('user_2', auth()->user()->profile->id)->pluck("user_1")->toArray();

        $me_sending = Message::where('user_1',$id)->pluck("user_2")->toArray();
        // Get users sent me messages (just in case I didn't answer)
        $send_me =  Message::where('user_2', $id)->pluck("user_1")->toArray();
        
        $all = array_merge($me_sending, $send_me);
        $all= array_unique($all);     
        

        // Query profiles        
        // $contacts=Profil::whereIn('id',$all)->paginate(9);               
            

        $unread = \DB::table('messages')
        ->where('user_2', $id)
        ->orderBy('seen')
        ->distinct('user_1');

        $contacts = \DB::table('users')
        ->where('status_id', '=', 3) 
        ->join('profils', 'profils.user_id', '=', 'users.id')
        ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
        ->where('pictures.is_main', '=', 1) 
        ->whereIn('profils.id', $all) 
        ->joinSub($unread, 'unread', function ($join) {
            $join->on('profils.id', '=', 'unread.user_1');
        })
        ->orderBy('seen')
        ->distinct("id")
        ->select('profils.id','users.name','picture','birthday', 'status_id', 'seen')->get();
        
        
        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        
        return ['profiles'=>$contacts, 'users_unread_messages'=>$users_unread_messages ];

        // return view('messages.list_discussions',['profiles'=>$contacts,
        //                                         'users_unread_messages'=>$users_unread_messages ]);
        // ->with('profiles',$contacts);

    }





    public function store(Request $request){ 
       
        $request->validate([
            'message' => 'required',            
        ])  ;


        $id = $request['current_user'];       
        // Check if the 2 users are still matched
        $me_matched = Matching::where('user_1','=',auth()->user()->profile->id)
                ->where('user_2', $id)->first(); 
        $other_matched = Matching::where('user_2','=',auth()->user()->profile->id)
                ->where('user_1', $id)->first();

        if(is_null($me_matched) || is_null($other_matched)){            
            return redirect()->route('get_profile', auth()->user()->profile->id)->with("error", 'Unauthorized action!');
        }       

        $message = new Message;
        $message->user_1 = auth()->user()->profile->id;
        $message->user_2 = $request['current_user'];
        $message->message = $request['message'];
        $message->seen = 0;
        $message->save();       

        return redirect()->route('messages', [auth()->user()->profile->id, $request['current_user']]);
    }


   


}
