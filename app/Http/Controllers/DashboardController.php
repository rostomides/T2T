<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;



use App\User;
use App\Status;
use App\Sex;
use App\Profil;
use App\StatusInCanada;
use App\Location;
use App\MaritalStatus;
use App\HowManyChildren;
use App\ChildrenWithYou;
use App\Education;
use App\BodyType;
use App\Dress;
use App\Profession;
use App\SelfDescription;
use App\LookingFor;
use App\Ethnicity;
use App\CountryGrewUp;
use App\Hobby;
use App\Language;
use App\Interview;
use App\Picture;
use App\Message;
use App\Payment;
use App\Flag;
use App\ Feedback;


class DashboardController extends Controller
{
    // -----------------------------------------------
    // Link to dahsboard for admins
    // -----------------------------------------------
    public function index(){  
        return view('dashboard.dashboard_base', $this->common_values()); 
    }

    // -----------------------------------------------
    // Common values to work with in dashboard
    // -----------------------------------------------
    private function common_values(){
        $interview_count = User::where('status_id', 2)->count(); 
        $active_count = User::where('status_id', 3)->count();
        $expired_count = User::where('status_id', 4)->count();
        $banned_count = User::where('status_id', 5)->count();
        $new_flags = Flag::where('admin_check', 0)->count();
        return([
            'interview_count'=>$interview_count,
            'active_count'=>$active_count,
            'expired_count'=>$expired_count,
            'banned_count'=>$banned_count,
            'new_flags'=>$new_flags,
        ]);
    }

    // -----------------------------------------------
    // Get the list of statuses
    // -----------------------------------------------
    private function statuses_list(){
        return Status::whereIn('id', [3,4,5])->get();
    }


    // -----------------------------------------------
    // Link to interviews in the dashboard
    // -----------------------------------------------
    public function interviews(){  
        $users = User::where("status_id", 2)->get();          
        return view('dashboard.interviews', 
            array_merge(["users"=>$users ], $this->common_values(),
            ['statuses' => $this->statuses_list()])
        );
    }


    // -----------------------------------------------
    // Link to active users in the dashboard
    // -----------------------------------------------
    public function active_users(){  
        $users = User::where("status_id", 3)->get();          
        return view('dashboard.active_users', 
            array_merge(["users"=>$users ], $this->common_values(),
        ['statuses' => $this->statuses_list()])
        );
    }

    // -----------------------------------------------
    // Link to active users in the dashboard
    // -----------------------------------------------
    public function expired_users(){
        $users = User::where("status_id", 4)->get();          
        return view('dashboard.expired_users', 
            array_merge(["users"=>$users ], $this->common_values(),
            ['statuses' => $this->statuses_list()])
        );
    }

    // -----------------------------------------------
    // Link to active users in the dashboard
    // -----------------------------------------------
    public function admin_banned_users(){        
        
        $users = User::where("status_id", 5)->get();          
        return view('dashboard.banned_users', 
            array_merge(["users"=>$users ], $this->common_values(),
            ['statuses' => $this->statuses_list()])
        );
    }



    // -----------------------------------------------
    // manage admin page
    // -----------------------------------------------
    public function manage_admin(){  
        
        $users = User::where("role_id",'<', '3')->get();    
        return view('dashboard.manage_admins', 
            array_merge(["users"=>$users ], $this->common_values())
        );
    }

    // ------------------------------------------------
    // Repport of the interview
    // ------------------------------------------------
    public function save_interview_report(Request $request){
        // Check if the report exsits
        $create = false;
        $interview = Interview::where("profil_id", $request["profil_id"])->first();
        if(is_null($interview)){
            $interview = new Interview;
            $create = true;
        }
        
        $interview->profil_id = $request["profil_id"];
        $interview->report = $request["report"];

        if($create){
            $interview->save();
            // Activate the user
            $user = Profil::find($request["profil_id"])->user;
            $user->status_id = 3;    
            $user->update();        
        }else{
            $interview->update();
        }    
        

        if($create){
            // Send email to the user
            $send_to = Profil::find($request["profil_id"])->user->email;        
            $title = 'Account activation';
            $content = 'Your account is now active, you can use all the features offered by the tayeboon2tayebat website. May Allah help you find the right match.';
               
            \Mail::send('mail.account_activation', ['title' => $title,
                    'content' => $content], function ($message) use($title, $send_to)
            {
    
                $message->from('me@gmail.com', 'Tayeboon2tayebat admin');
                $message->subject('Tayeboon2tayebat: '.$title);
                $message->to($send_to);
    
            });
        }

        return redirect()->route('admin_get_profile', $request["profil_id"])->with("success", "The interview report has been saved successfully! The user's status is active.");
    }


    // --------------------------------------------------------------------
    // Get profile by ID
    // --------------------------------------------------------------------
    public function get_profile($id){ 
        // check if id is equal to connected id        
        $profile = "";        
        $profile = Profil::find($id);
        
        $main_pict = Picture::where("profil_id", $id)->where("is_main", 1)->first()->picture;
        
        if (is_null($profile)){
            return back();
        }       
        
        $profil_name = $profile->user->name;
        
        
        // For admin interview        
        $interview = Interview::where('profil_id', $profile->id)->first();

        if(is_null( $interview )){ // If the user has not been interviewed
            return view('profiles.get_profile', ['profile'=>$profile, 'main_pict'=>$main_pict,'profil_id'=>$id, 'profil_name'=>$profil_name]);
        }
        return view('profiles.get_profile', ['profile'=>$profile, 'interview_report'=>$interview,
                                            'main_pict'=>$main_pict, 'profil_id'=>$id,
                                            'profil_name'=>$profil_name]);

    }// END: Get profile by ID




    // ---------------------------
    // Create a free account for a user 
    // ---------------------------
    public function create_free_account(){

        return view('dashboard.free_account', $this->common_values());

    }

    // -----------------------------------------------
    // Store a free account
    // -----------------------------------------------
    public function store_free_account(Request $request){

        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',            
        ]) ;   

        $user = new User;
        $user->name = 'Please complete your name';
        $user->email= $request['email'];
        $user->password= Hash::make('freeaccount');
        $user->role_id= 3; //Correspond to customer
        $user->status_id= 1;// Corresponds to the status of registerd
        $user->save();

        // Create a new payment entry
        $expiration_date = date('Y-m-d', strtotime(date('Y-m-d')) + (366*24*3600));
        $payment = new Payment;
        $payment->user_id = $user->id;
        $payment->payment_date = date('Y-m-d'); //format accepted by sql
        $payment->expiration_date = $expiration_date;
        $payment->save();

        // Send email


        return redirect()->route('create_free_account')->with('success', 'Free account created successfully!');
    }


    // -----------------------------------------------
    // Get user's discussion list
    // -----------------------------------------------
    public function users_discussions($id){
        // Get users that I have sent messages to (just in case they didn't answer)
        $me_sending = Message::where('user_1', $id)->pluck("user_2")->toArray();
        // Get users sent me messages (just in case I didn't answer)
        $send_me =  Message::where('user_2', $id)->pluck("user_1")->toArray();
        
        $all = array_merge($me_sending, $send_me);
        $all= array_unique($all);     
        
        $profil_name = Profil::find($id)->user->name;
        // Query profiles
        $contacts = \DB::table('users')
            ->join('profils', 'profils.user_id', '=', 'users.id')
            ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
            ->where('pictures.is_main', '=', 1)            
            ->whereIn('profils.id', $all)
            ->select('profils.id','users.name','picture','birthday')->paginate(9); 

        return view('messages.list_discussions',['profiles'=>$contacts, 'profil_id'=>$id, 'profil_name'=>$profil_name]);
    }

    // -----------------------------------------------
    // Get the messages between 2 users
    // -----------------------------------------------
    public function users_messages($id1, $id2){  
        // get the messages
        $messages=Message::where(function($query) use($id2,$id1){
            $query->where('user_1', $id1)
                ->where('user_2', $id2);
        })        
        ->orWhere(function($query1) use($id2,$id1){
            $query1->where('user_2', $id1)
            ->where('user_1', $id2);
        })->orderBy('created_at')->get();
        

        // Get the name of the persons chatting
        $first_user= Profil::find($id1);
        $profile_name = $first_user->user->name;
        $second_user=Profil::find($id2); 
        
        return view('messages.admin_messages')->with(["messages"=> $messages, 
                                                'first_user'=>$first_user,
                                                'second_user'=>$second_user,
                                                'profil_id'=>$id1,
                                                'profil_name'=>$profile_name 
                                                ]);
    }

    // -----------------------------------------------
    // Change status
    // -----------------------------------------------
    public function Change_user_status(Request $request){
        
        // Get the user
        $user= User::findOrFail($request['user_id']);
        if($request['status'] == 3){
                 
            if( strtotime($user->profile->membership_end) < strtotime(date('Y-m-d'))){
                return redirect()->back()->with('error', 'The satus cannot be changed to Active, please Change the expiration date to a date higher than today\'s one');
            }
        }

        // update status
        $user->status_id = $request['status'];
        $user->update();


        return redirect()->back()->with('success', 'Status succefully updated!');
    }


    // -----------------------------------------------
    // Change Expiration date
    // -----------------------------------------------
    public function Change_expiration_date(Request $request){
        
        $user= User::findOrFail($request['user_id']);
        

        // Test if the new date is higher tan today's date        
        $new_date = strtotime($request['expire_date']);        
        if($new_date > strtotime(date('Y-m-d'))){            
            // Change expiration date in Profile
            $profile = Profil::find($user->profile->id);
            
            $profile->membership_end = date("Y-m-d", strtotime($request['expire_date']));
            $profile->update();
            

            // Modify the payment table 
            // Prolong the last payment
            $payment = Payment::where("user_id", $request['user_id'])->orderBy('expiration_date', 'desc')->first();
            
            if(!is_null($payment)){ //rEMOVE THIS IF BEFORE PRODUCTION
                $payment->expiration_date = date("Y-m-d", strtotime($request['expire_date']));
                $payment->update();
            }
            
            
            return redirect()->back()->with('success', 'Expiration date succefully updated!');

        }else{
            return redirect()->back()->with('error', 'The new expiration date must be higher of today\'s date!');
        }
        
    }



    // -----------------------------------------------
    // Link to flagged users 
    // -----------------------------------------------
    public function flagged_users(){
        $route = Route::getCurrentRoute()->getName();
        if($route == "admin_flagged_users"){
            $flags = Flag::where('admin_check', 1)->orderBy('created_at')->get();
            $route = 1;
            
        }else if($route == "admin_new_flagged_users"){
            $flags = Flag::where('admin_check', 0)->orderBy('created_at')->get();
            $route = 0;
        }
        
        return view('dashboard.flagged', ['flags'=>$flags, "page"=>$route])->with( $this->common_values());
                 
    }

    // -----------------------------------------
    // Action to be taken toward a flagged user
    // -----------------------------------------

    public function flagged_action(Request $request){

        $request->validate([
            'action' => 'required'
            
        ])  ;
        

        if($request['action'] == 1){ //Not relevent ignore it
            Flag::find($request['flag_id'])->delete();
            return redirect()->back()->with('success', "Flag successfully ignored!");
        }elseif($request['action'] == 2){ //Confirm the flag without banning the user
            $flag = Flag::find($request['flag_id']);
            $flag->admin_check = 1;
            $flag->update();
            return redirect()->back()->with('success', "Flag successfully Confirmed!");

        }elseif($request['action'] == 3){ //Confirm the flag without banning the user
            $flag = Flag::find($request['flag_id']);
            $flag->admin_check = 1;
            $flag->update();

            $user = User::find($request['flagged_user_id']);
            $user->status_id = 5;
            $user->update();
            return redirect()->back()->with('success', "Flag successfully Confirmed and user successfully banned!");
        }else{
            return redirect()->route('dashboard')->with('error', 'Action not allowed');
        }
    }


    // ----------------------------------
    // Sending feedback to admin
    // ----------------------------------

    public function feedback(Request $request){

        $request->validate([
            'feedback' => 'required',            
        ])  ;  
        
        $fb = new Feedback;
        $fb->user_id = auth()->user()->id;
        $fb->feedback = $request['feedback'];
        $fb->save();

        return redirect()->back()->with('success', 'Thank you very much for giving us your feedback. It will really help us in the future to improve our users experience.');

        

    }

    


}
