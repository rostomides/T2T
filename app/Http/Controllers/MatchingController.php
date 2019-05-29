<?php

namespace App\Http\Controllers;
use App\Matching;
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
use App\Traits\my_traits;


use Illuminate\Http\Request;

class MatchingController extends Controller
{
    // ----
    use my_traits; // This is an important line for the trait to be loaded
    // ----



    // ----------------------------
    // Matching
    // ----------------------------
    public function match(Request $request){
        
        $matching = new Matching;
        $matching->user_1 = auth()->user()->profile->id;
        $matching->user_2 = $request['current_user'];
        $matching->seen = 0;
        $matching->save();

        $id = $request['current_user'];


        // Send email to the user
        $sender = "Tayeboon2tayebat admin";
        $send_to = Profil::find($id)->user->email;        
        $title = 'A user found your profile intersting and matched with you';
        $content = $sender. ' found your profile intersting.';

        
        
        \Mail::send('mail.mail', ['title' => $title, 'sender'=>$sender,
                'content' => $content], function ($message) use($title, $send_to)
        {

            $message->from('me@gmail.com', 'Tayeboon2tayebat admin');
            $message->subject('Tayeboon2tayebat: '.$title);
            $message->to($send_to);

        });

        
        if ($this->get_previous_route() == 'get_profile'){
            return redirect()->route('get_profile', $request['current_user']);
        }else if($this->get_previous_route() == "matched_me"){
            return redirect()->route("matched_me");
        }   

    }

    // ----------------------------
    // Unmatching
    // ----------------------------
    public function unmatch(Request $request){        
        // Get the matching combination
        $matching = Matching::where('user_1','=', auth()->user()->profile->id)
        ->where('user_2', $request['current_user'])->first();        
        $matching->delete();


        $id = $request['current_user'];


        // Send email to the user
        $sender = "Tayeboon2tayebat admin";
        $send_to = Profil::find($id)->user->email;        
        $title = 'A user has unmatched you';
        $content = $sender. ' has unmatched you.';

        
        
        \Mail::send('mail.mail', ['title' => $title, 'sender'=>$sender,
                'content' => $content], function ($message) use($title, $send_to)
        {

            $message->from('me@gmail.com', 'Tayeboon2tayebat admin');
            $message->subject('Tayeboon2tayebat: '.$title);
            $message->to($send_to);

        });
        

        // Depending on the previous page return 
        
        if ($this->get_previous_route() == 'get_profile'){
            return redirect()->route('get_profile', $request['current_user']);
        }else if($this->get_previous_route() == "my_matches"){
            return redirect()->route("my_matches");
        } else if($this->get_previous_route() == "both_match"){
            return redirect()->route("both_match");
        }        
    }
 
    // ------------------------------------
    // See all matches
    // ------------------------------------

    public function my_matches(){       
        // Take all users that have been matched and remove those who matched back
        $my_matches = Matching::where('user_1','=', auth()->user()->profile->id)->pluck('user_2')->toArray();
        $both_matched = Matching::whereIn('user_1', $my_matches)
                                ->where('user_2', '=', auth()->user()->profile->id)->pluck('user_1')->toArray();

        $my_matches_clean = array_diff($my_matches, $both_matched);
        // $profiles = Profil::whereIn('id', $my_matches_clean)->paginate(9);


        $profiles = \DB::table('users')
            ->join('profils', 'profils.user_id', '=', 'users.id')
            ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
            ->join('locations', 'profils.location_id', '=', 'locations.id')
            ->where('pictures.is_main', '=', 1)            
            ->whereIn('profils.id', $my_matches_clean)
            ->where('status_id', '=', 3)
            ->select('profils.id','users.name','picture','birthday', 'sex_id', 'location')->get();


        
        
        if(sizeof($profiles) == 0){
            $profiles=null;
        };

        $return_data = $this->load_data();   
        $return_data['profiles']  = $profiles; 
        
        
        $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
        $return_data['n_unseen_matched_me']  = $n_unseen_matched_me;

        $n_unseen_both_matched = $this->how_many_both_matched_not_seen();
        $return_data['n_unseen_both_matched']  = $n_unseen_both_matched;

        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        $return_data['users_unread_messages']  = $users_unread_messages;

        $return_data['action'] = 'unmatch';
        

        // Send also a variable to allow the user to unmatch based on this list        
        return view('search.search_profiles')->with($return_data); 
        
    }


    public function matched_me(){        
        // Take all users that matched me and remove those who I matched back
        $matched_me = Matching::where('user_2','=',auth()->user()->profile->id)->pluck('user_1')->toArray();
        $both_matched = Matching::whereIn('user_2', $matched_me)
                                ->where('user_1', '=', auth()->user()->profile->id)->pluck('user_2')->toArray();

        $matched_me_clean = array_diff($matched_me, $both_matched);
         
        // $profiles = Profil::whereIn('id',$matched_me_clean)->paginate(9);

        $profiles = \DB::table('users')
            ->join('profils', 'profils.user_id', '=', 'users.id')
            ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
            ->join('locations', 'profils.location_id', '=', 'locations.id')
            ->where('pictures.is_main', '=', 1)            
            ->whereIn('profils.id', $matched_me_clean)
            ->where('status_id', '=', 3)
            ->select('profils.id','users.name','picture','birthday', 'sex_id', 'location')->get();
        
        //Update the seen of the users that matched me
        
        if(sizeof($profiles) == 0){
            $profiles=null;
        };

        $return_data = $this->load_data();   
        $return_data['profiles']  = $profiles;

        // Update the seen field of all matched me that I haven't seen yet (Comes from the traits)  
        \DB::table('matchings')->where('user_2','=', auth()->user()->profile->id)
                            ->whereIn('user_1', $matched_me_clean)
                            ->update(['seen'=>1]);
                            
        $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
        $return_data['n_unseen_matched_me']  = $n_unseen_matched_me;

        $n_unseen_both_matched = $this->how_many_both_matched_not_seen();
        $return_data['n_unseen_both_matched']  = $n_unseen_both_matched;

        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        $return_data['users_unread_messages']  = $users_unread_messages;


        $return_data['action'] = 'match';

        // Send a variable to allow the user to match also        
        return view('search.search_profiles')->with($return_data);
    }



    public function  both_match(){
        $matched_me = Matching::where('user_2','=',auth()->user()->profile->id)->pluck('user_1')->toArray();
        $my_matches = Matching::where('user_1','=', auth()->user()->profile->id)->pluck('user_2')->toArray();
        
        $both_matched = array_intersect($matched_me, $my_matches);
        // $profiles = Profil::whereIn('id',$both_matched)->paginate(9);

        $profiles = \DB::table('users')
                    ->join('profils', 'profils.user_id', '=', 'users.id')
                    ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
                    ->join('locations', 'profils.location_id', '=', 'locations.id')
                    ->where('pictures.is_main', '=', 1)                    
                    ->whereIn('profils.id', $both_matched)
                    ->where('status_id', '=', 3)
                    ->select('profils.id','users.name','picture','birthday', 'sex_id', 'location')->get();
        
        if(sizeof($profiles) == 0){
            $profiles=null;
        };

        $return_data = $this->load_data();   
        $return_data['profiles']  = $profiles;
        // Send a variable to allow the user to match also

        \DB::table('matchings')->where('user_2','=', auth()->user()->profile->id)
                            ->whereIn('user_1', $both_matched)                            
                            ->update(['seen'=>1]);                           


        $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
        $return_data['n_unseen_matched_me']  = $n_unseen_matched_me;

        $n_unseen_both_matched = $this->how_many_both_matched_not_seen();
        $return_data['n_unseen_both_matched']  = $n_unseen_both_matched;

        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        $return_data['users_unread_messages']  = $users_unread_messages;

        $return_data['action'] = 'unmatch';
        
        return view('search.search_profiles')->with($return_data);
    }





    private function get_previous_route()
    {
        $previousRequest = app('request')->create(url()->previous());

        try {
            $previousRouteName = app('router')->getRoutes()->match($previousRequest)->getName();
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception) {
            // Exception is thrown if no matching route found.
            // This will happen for example when comming from outside of this app.
            return false;
        }

        return $previousRouteName;
    }



    private function load_data(){

        $statusCanada = StatusInCanada::get(["id", "status_in_canada"]);
        $locations = Location::get(["id", "location"]);
        $maritalstatus = MaritalStatus::get(["id", "marital_status"]);       
        $educations = Education::get(["id", "education"]);        
        $dresses = Dress::get(["id", "dress"]);        
        $ethnicities = Ethnicity::get(["id", "ethnicity"]);
        $grew_ups = CountryGrewUp::get(["id", "country_grew_up"]);        
        $languages = Language::orderBy("language")->get(["id", "language"]);       

        return Array( 
        
            'status_in_canada'=>$statusCanada,
            'locations'=>$locations, 
            'marital_status'=>$maritalstatus,            
            'educations' =>$educations,            
            'dresses'=>$dresses,            
            'ethnicities'=>$ethnicities,
            'grew_ups'=>$grew_ups,            
            'languages'=>$languages           
        );

    }



   
}
