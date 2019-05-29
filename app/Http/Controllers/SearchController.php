<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
use App\Matching;
use App\Picture;

use App\Traits\my_traits;

class SearchController extends Controller
{

    // ----
    use my_traits; // This is an important line for the trait to be loaded
    // ----




    // -------------------------------
    // Return the search page
    // -------------------------------
    public function index(){
        $sex = 1;
        $profiles=null;
        if(auth()->user()->profile->sex->id == 1){         
            $sex = 2;
        }

        $profiles = \DB::table('users')
        ->join('profils', 'profils.user_id', '=', 'users.id')
        ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
        ->join('locations', 'profils.location_id', '=', 'locations.id')
        ->where('pictures.is_main', '=', 1)
        ->where('profils.sex_id', '=', $sex)
        ->where('status_id', '=', 3)
        ->select('users.id','users.name','picture','birthday', 'sex_id', 'location')->paginate(9);
              

        

        $return_data = $this->load_data();   
        $return_data['profiles']  = $profiles; 
        
        
        $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
        $return_data['n_unseen_matched_me']  = $n_unseen_matched_me;

        $n_unseen_both_matched = $this->how_many_both_matched_not_seen();
        $return_data['n_unseen_both_matched']  = $n_unseen_both_matched;

        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        $return_data['users_unread_messages']  = $users_unread_messages;
        
        // dd(json_decode($return_data['locations'], true)[0]['location_id']);

        
        // Send also a variable to allow the user to unmatch based on this list        
        return view('search.search_profiles')->with($return_data);
    }


    // ---------------------------
    // Search for profiles
    // ---------------------------
    public function search_profiles(Request $request){

        // Check age coherence
        if(!is_null($request['min-age']) && !is_null($request['max-age']) ){
            if($request['min-age'] >= $request['max-age']){
                return redirect()->route('all_active_users')->with('error', 'Minum age must be lower than the maximum age');
            }
        }

        $sex = 1;
        $profiles=null;
        if(auth()->user()->profile->sex->id == 1){         
            $sex = 2;
        }          
        
        // Base query
        $profiles = \DB::table('users')
        ->join('profils', 'profils.user_id', '=', 'users.id')
        ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
        ->join('language_profil', 'profils.id', '=', 'language_profil.profil_id')
        ->join('locations', 'profils.location_id', '=', 'locations.id')
        ->where('pictures.is_main', '=', 1)
        ->where('status_id', '=', 3)
        ->where('profils.sex_id', '=', $sex);
        
             
        

        // Minimum age
        if(!is_null($request['min-age'])){       
            $min_date = \Carbon\Carbon::now()->addYears("-".$request['min-age']);
            $profiles->where('profils.birthday', '<=', $min_date);   
            
        }
        // Maximum age
        if(!is_null($request['max-age'])){       
            $max_date = \Carbon\Carbon::now()->addYears("-".($request['max-age'] +1)); 
            $profiles->where('profils.birthday', '>=', $max_date);       
        }

        // Ethnicity
        if(!is_null($request['ethnicity'])){ 
            $profiles->whereIn('profils.ethnicity_id', [$request['ethnicity']]);       
        }

        //language
        if(!is_null($request['languages'])){             
            $profiles->whereIn('language_id', [$request['languages']]);
                  
        }
        //Country grew up
        if(!is_null($request['country_grew_up'])){             
            $profiles->whereIn('countrygrewup_id', [$request['country_grew_up']]);
                  
        }
        //Status in Canada
        if(!is_null($request['status_in_canada'])){             
            $profiles->whereIn('statusincanada_id', [$request['status_in_canada']]);
                  
        }
        

        //Location
        if(!is_null($request['location'])){             
            $profiles->whereIn('location_id', [$request['location']]);                  
        }

        //Marital_status
        if(!is_null($request['marital_status'])){             
            $profiles->whereIn('maritalstatus_id', [$request['marital_status']]);                  
        }

        //Has children
        if(!is_null($request['haschildren'])){             
            $profiles->whereIn('haschildren', [$request['haschildren']]);                  
        }

        //Relocate
        if(!is_null($request['relocate'])){             
            $profiles->whereIn('haschildren', [$request['relocate']]);                  
        }

        //Education
        if(!is_null($request['education'])){             
            $profiles->whereIn('education_id', [$request['education']]);                  
        }


        $profiles = $profiles->select('users.id','users.name','picture','birthday', 'sex_id', 'users.status_id', 'location')->get();
        // dd($profiles);
        // json_decode($maritalstatus, true)
        // dd(json_decode($profiles,true));
        // $profiles_ids = $profiles->distinct('profils.id')->pluck('profils.id');      
        
        // $profiles = \DB::table('users')
        // ->join('profils', 'profils.user_id', '=', 'users.id')        
        // ->join('pictures', 'profils.id', '=', 'pictures.profil_id') 
        // ->where('pictures.is_main', '=', 1)    
        // ->whereIn('profils.id', $profiles_ids)
        // ->select('users.id','users.name','picture','birthday', 'sex_id', 'users.status_id')
        // ->get()->toarray();
                
        
        if(sizeof($profiles) == 0){
            $profiles=null;
        };      
        
        
        // $paginate = 9;
        // $page = \Illuminate\Support\Facades\Input::get('page', 1);
        
    
        // $offSet = ($page * $paginate) - $paginate;  
        // $itemsForCurrentPage = array_slice($profiles, $offSet, $paginate, true);  
        // $result = new LengthAwarePaginator($itemsForCurrentPage, count($profiles), $paginate, $page);
        // $profiles = $result;
        // // return $result;

        // dd($profiles);
        

        $return_data = $this->load_data();   
        // $return_data['profiles']  = $profiles; 
        
        
        $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
        $return_data['n_unseen_matched_me']  = $n_unseen_matched_me;

        $n_unseen_both_matched = $this->how_many_both_matched_not_seen();
        $return_data['n_unseen_both_matched']  = $n_unseen_both_matched;

        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        $return_data['users_unread_messages']  = $users_unread_messages;

        
        

        // Send also a variable to allow the user to unmatch based on this list        
        return view('search.search_profiles',['profiles'=>$profiles, "sorting"=>""])->with($return_data);  


    }


    // -------------------------------
    // Load data needed for the search page
    // --------------------------------
    private function load_data(){
        

        // Function returning a basic Query

        function basic_query(){
            $sex = 1;
            if(auth()->user()->profile->sex_id  == 1){
                $sex = 2;
            }

            $basic_query = \DB::table('profils')
            ->join('users', 'users.id', '=', 'profils.user_id')
            ->where('profils.sex_id', '=', $sex)
            ->join('locations', 'profils.location_id', '=', 'locations.id')
            ->where('status_id', '=', 3);
            return $basic_query;
        }
        
        $statusCanada = StatusInCanada::get(["id", "status_in_canada"]);
        $locations = Location::get(["id", "location"]);
        $maritalstatus = MaritalStatus::get(["id", "marital_status"]);       
        $educations = Education::get(["id", "education"]);        
        $dresses = Dress::get(["id", "dress"]);        
        $ethnicities = Ethnicity::get(["id", "ethnicity"]);
        $grew_ups = CountryGrewUp::get(["id", "country_grew_up"]);        
        $languages = Language::orderBy("language")->get(["id", "language"]);   
        

        // Available locations
        // -----------------------------
        // $locations_available = basic_query()->selectRaw('location_id, count(*) as count_locations')
        // ->groupby('location_id');
        // $locations = \DB::table('locations')
        // ->joinSub($locations_available, 'locations_available', function ($join) {
        //     $join->on('locations.id', '=', 'locations_available.location_id');
        // })->select('location_id', 'location', 'count_locations' )
        // ->get();

        // Available Marital statuses
        // -----------------------------
        // $maritalstatus_available = basic_query()->selectRaw('maritalstatus_id, count(*) as count_maritalstatus')
        // ->groupby('maritalstatus_id');        

        // $maritalstatus = \DB::table('marital_statuses')
        // ->joinSub($maritalstatus_available, 'maritalstatus_available', function ($join) {
        //     $join->on('marital_statuses.id', '=', 'maritalstatus_available.maritalstatus_id');
        // })->select('maritalstatus_id', 'marital_status', 'count_maritalstatus')
        // ->get();        
        
        // Available Statuses in Canada
        // -----------------------------
        // $status_canada_available = basic_query()->selectRaw('statusincanada_id, count(*) as count_statusincanada')
        // ->groupby('statusincanada_id'); 

        // $statusCanada = \DB::table('status_in_canadas')
        // ->joinSub($status_canada_available, 'status_canada_available', function ($join) {
        //     $join->on('status_in_canadas.id', '=', 'status_canada_available.statusincanada_id');
        // })->select('statusincanada_id', 'status_in_canada', 'count_statusincanada')
        // ->get();   
       


        return Array( 
        
            'status_in_canada'=>json_decode($statusCanada, true),
            'locations'=>json_decode($locations, true), 
            'marital_status'=>json_decode($maritalstatus, true),            
            'educations' =>$educations,            
            'dresses'=>$dresses,            
            'ethnicities'=>$ethnicities,
            'grew_ups'=>$grew_ups,            
            'languages'=>$languages           
        );

    }



    // -------------------------------
    //  Sorting users
    // --------------------------------
    public function sort_users(Request $request){
        
        $profiles = null;
        if(is_null($request['sort_search'])){
            return redirect()->route("all_active_users");

        }else{

            function base_query(){
                $sex = 1;
                if(auth()->user()->profile->sex->id == 1){         
                    $sex = 2;
                }

                $prs = \DB::table('users')
                ->join('profils', 'profils.user_id', '=', 'users.id')
                ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
                ->join('locations', 'profils.location_id', '=', 'locations.id')
                ->where('pictures.is_main', '=', 1)
                ->where('profils.sex_id', '=', $sex)
                ->where('status_id', '=', 3)
                ->select('users.id','users.name','picture','birthday', 'sex_id', 'profils.created_at', 'location');
                return $prs;
            }
            
            if($request['sort_search'] == "age"){                
                $profiles = base_query()
                ->orderBy('birthday', 'desc')
                ->get();                
            }
            else if($request['sort_search'] == "nameZA"){
                $profiles = base_query()
                ->orderBy('name', 'desc')
                ->get(); 
            }
            else if($request['sort_search'] == "nameAZ"){
                $profiles = base_query()
                ->orderBy('name')
                ->get(); 
            }
            else if($request['sort_search'] == "first"){
                $profiles = base_query()
                ->orderBy('created_at')
                ->get(); 
            }
            else if($request['sort_search'] == "last"){
                $profiles = base_query()
                ->orderBy('created_at', 'desc')
                ->get(); 
            }
        }
        

        $return_data = $this->load_data();   
        $return_data['profiles']  = $profiles; 
        
        
        $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
        $return_data['n_unseen_matched_me']  = $n_unseen_matched_me;

        $n_unseen_both_matched = $this->how_many_both_matched_not_seen();
        $return_data['n_unseen_both_matched']  = $n_unseen_both_matched;

        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        $return_data['users_unread_messages']  = $users_unread_messages;        
        
        // set a variable to show the sorting form
        $sorting = 1;
        
        // Send also a variable to allow the user to unmatch based on this list        
        return view('search.search_profiles', ['sorting'=>$sorting])->with($return_data);


    }

    // -------------------------------
    //  Search user by name
    // --------------------------------
    public function search_user_by_name(Request $request){

        $request->validate([
            'username_search' => 'required',            
        ])  ;
        
        $profiles = null;
        
        $sex = 1;
        if(auth()->user()->profile->sex->id == 1){         
            $sex = 2;
        }

        $un = strtolower($request['username_search']);

        if($request['search_type'] == "startswith"){
            $profiles = \DB::table('users')        
            ->join('profils', 'profils.user_id', '=', 'users.id')
            ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
            ->join('locations', 'profils.location_id', '=', 'locations.id')
            ->where('pictures.is_main', '=', 1)
            ->where('profils.sex_id', '=', $sex)
            ->where('status_id', '=', 3)
            ->where('name', 'LIKE', "$un%")
            ->select('users.id','users.name','picture','birthday', 'sex_id', 'profils.created_at', 'location')->get();
        }else if($request['search_type'] == "contains"){
            $profiles = \DB::table('users')        
            ->join('profils', 'profils.user_id', '=', 'users.id')
            ->join('pictures', 'profils.id', '=', 'pictures.profil_id')
            ->join('locations', 'profils.location_id', '=', 'locations.id')
            ->where('pictures.is_main', '=', 1)
            ->where('profils.sex_id', '=', $sex)
            ->where('status_id', '=', 3)
            ->where('name', 'LIKE', "%$un%")
            ->select('users.id','users.name','picture','birthday', 'sex_id', 'profils.created_at', 'location')->get();
        } else{
            $profiles = null;
        }
        
        if(sizeof($profiles) == 0){
            $profiles = null;
        }

        $return_data = $this->load_data();   
        $return_data['profiles']  = $profiles; 
        
        
        $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
        $return_data['n_unseen_matched_me']  = $n_unseen_matched_me;

        $n_unseen_both_matched = $this->how_many_both_matched_not_seen();
        $return_data['n_unseen_both_matched']  = $n_unseen_both_matched;

        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();
        $return_data['users_unread_messages']  = $users_unread_messages;        
        
        // set a variable to show the sorting form
        $sorting = 1;
        
        // Send also a variable to allow the user to unmatch based on this list        
        return view('search.search_profiles', ['sorting'=>$sorting])->with($return_data);


    }


}
