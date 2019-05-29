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



    // ---------------------------------
    // Function returning all messages
    // ---------------------------------

    private function return_messages($id1, $id2){
        // Check id1 corresponds to the logged user
        $logged_id = auth()->user()->profile->id;
        if(($id1!=$logged_id) || ($id1==$logged_id && $id2==$logged_id)){
            return "error1";
        }

        // Get profil of the second user
        $second_user = Profil::find($id2);

        // Check if the id2 is of opposite sex
        if(auth()->user()->profile->sex_id == $second_user->sex_id){
            return "error2";        
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
            ->join('locations', 'profils.location_id', '=', 'locations.id')
            ->where('pictures.is_main', '=', 1) 
            ->where('profils.id', $id2)             
            ->select('profils.id','users.name','picture','birthday', 'status_id', 'location')->first();


        return [ 
            'profile'=>$profile,
            "messages"=> $messages, 
            'second_user'=>$second_user,
            'still_matched'=>$still_matched
        ];
    }

    // ----------------------------
    // return the index page
    // -----------------------------
    public function index($id1, $id2){   

        $data = $this->return_messages($id1, $id2);

        if($data == "error1"){
            return redirect()->route('get_profile', auth()->user()->profile->id)->with("error", 'Unauthorized action!');
        }else if ($data == "error2"){
            return redirect()->route('my_profile')->with("error", 'Unauthorized action!');
        }        
        
        return view('messages.messages')->with($data);
    }

    function return_messages_js($id1, $id2){
        #Returns the messages for javascript updating the message area
        return $this->return_messages($id1, $id2)["messages"];
    }

    // -----------------------------
    // store new messages
    // ----------------------------
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



        // Send email to the user
        $sender = Profil::find(auth()->user()->profile->id)->user->name;
        $send_to = Profil::find($id)->user->email;
        // dd($send_to);
        $title = 'You have received a new message from '.$sender;
        $content = $request['message'];

        
        
        \Mail::send('mail.mail', ['title' => $title, 'sender'=>$sender,
                'content' => $content], function ($message) use($title, $send_to)
        {

            $message->from('me@gmail.com', 'Larbi bedrani');
            $message->subject('Tayeboon2tayebat: '.$title);
            $message->to($send_to);

        });

        


        
        return $this->return_messages(auth()->user()->profile->id, $id)["messages"];
        // return redirect()->route('messages', [auth()->user()->profile->id, $request['current_user']]);
    }


    public function my_discussions(){
        
        // Get users that I have sent messages to (just in case they didn't answer)
        $me_sending = Message::where('user_1', auth()->user()->profile->id)->pluck("user_2")->toArray();
        // Get users sent me messages (just in case I didn't answer)
        $send_me =  Message::where('user_2', auth()->user()->profile->id)->pluck("user_1")->toArray();
        
        $all = array_merge($me_sending, $send_me);
        $all= array_unique($all);     
        

        // Query profiles        
        // $contacts=Profil::whereIn('id',$all)->paginate(9);
        $contacts = \DB::table('users')
            ->where('status_id', '=', 3) 
            ->join('profils', 'profils.user_id', '=', 'users.id')
            ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
            ->where('pictures.is_main', '=', 1) 
            ->whereIn('profils.id', $all)             
            ->select('profils.id','users.name','picture','birthday', 'status_id')->get();
        
        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        

        return view('messages.list_discussions',['profiles'=>$contacts,
                                                'users_unread_messages'=>$users_unread_messages ]);
        // ->with('profiles',$contacts);

    }


}
