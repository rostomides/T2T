<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;


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
use App\Flag;
use App\Payment;
use App\Picture;
use Carbon\Carbon;
use App\Message;
use App\ Feedback;

use App\Traits\my_traits;

class ProfilController extends Controller
{
     // ----
     use my_traits; // This is an important line for the trait to be loaded
     // ----


    //  -----------------------------------------------
        // Information loader for create and edit pages
    // ------------------------------------------------
    private function information_loader(){
        $statusCanada = StatusInCanada::get(["id", "status_in_canada"]);
        $locations = Location::orderBy('location')->get(["id", "location"]);
        $maritalstatus = MaritalStatus::get(["id", "marital_status"]);
        $howmanychildren = HowManyChildren::get(["id", "number_of_children"]);
        $childrenwithyou = ChildrenWithYou::get(["id", "number_of_children_with_you"]);
        $educations = Education::get(["id", "education"]);
        $body_types = BodyType::get(["id", "body_type"]);
        $dresses = Dress::get(["id", "dress"]);
        $professions = Profession::orderBy("profession")->get(["id", "profession"]);
        $ethnicities = Ethnicity::get(["id", "ethnicity"]);
        $grew_ups = CountryGrewUp::get(["id", "country_grew_up"]);
        $hobbies = Hobby::orderBy("hobby")->get(["id", "hobby"]);
        $languages = Language::orderBy("language")->get(["id", "language"]);
        $sexes = Sex::orderBy("sex")->get(["id", "sex"]);

        return Array(
            'status_in_canada'=>$statusCanada,
            'locations'=>$locations, 
            'marital_status'=>$maritalstatus,
            'howmanychildren'=>$howmanychildren,
            'childrenwithyou'=>$childrenwithyou,
            'educations' =>$educations,
            'body_types'=>$body_types,
            'dresses'=>$dresses,
            'professions'=>$professions,
            'ethnicities'=>$ethnicities,
            'grew_ups'=>$grew_ups,
            'hobbies'=>$hobbies,
            'languages'=>$languages,
            'sexes'=>$sexes
        );

    }


    

    //--------------------------------------------------------
    // Return the page that allows to create the profile before interview
    // -------------------------------------------------------
    public function create_profile()  
    {       
        
        $profile_infos = $this->information_loader();

        return view('profiles.create_profile', $profile_infos);
        
    }

    // --------------------------------------------------------------------    
    // Store the informations of the profile 
    // --------------------------------------------------------------------
    public function store(Request $request){

        // dd($request->toarray());
        // This operation is allowed only if the user has a status of registred
        if(auth()->user()->status->id != 1){
            return redirect()->route('welcome')->with('error', 'operation not allowed!');
        }

        // Entry validation
        $request->validate([
            // 'birthday' => 'required',
            'year'=> 'required',
            'month'=> 'required',
            'day'=>'required',
            // 'phone'=>'required|regex:/^[0-9 ]+/',
            'phone-first-three'=>'required',
            'phone-second-three'=>'required',
            'phone-four'=>'required',
            'sex' => 'required',
            'relocate' => 'required',
            'haschildren'=>'required',
            'status_in_canada'=>'required',
            'marital_status'=>'required',
            'location'=>'required',
            'education'=>'required',
            'body_type'=>'required',
            'dress'=>'required',
            'profession'=>'required',
            'self_description'=>'required',
            'looking_for'=>'required', 
            'picture'=>'required|image|max:1999'
        ])  ;       


        // Validating phone number
        $phone = "";        
        if(strlen($request['phone-first-three']) == 3 && strlen($request['phone-second-three']) == 3 && strlen($request['phone-four']) == 4){
            $phone = $request['phone-first-three']."-".$request['phone-second-three']."-".$request['phone-four'];
            
        }
        if($phone===""){
            return redirect()->back()->with("error", "The phone number you provided is invalid. A valid phone number must be xxx-xxx-xxxx (x is a digit between 0 an 9).");
        }        
        
        
        // Check if age is lower than 18yo 
        $birthday =  $request['year']."-".$request['month']."-".$request['day'];        
        $age = (strtotime(date('Y-m-d')) - strtotime($birthday))/(3600*24*365);
        

        if($age<18){
            return redirect()->back()->with('error','You must be at least 18 years old to use this website!');
        }
        
        // Handle picture
        if($request->hasFile("picture")){
            $fileNameExt = $request->file("picture")->getClientOriginalName();
            
            // Get the name part of the file
            $fileName = pathinfo($fileNameExt, PATHINFO_FILENAME);
            
            // Get the extension part of the name
            $extension = $request->file("picture")->getClientOriginalExtension();
            
            // $fileNameToStore = $fileName."_".time().".". $extension;
            $fileNameToStore = "id_".auth()->user()->id."_".time().".". $extension;
            
            
            // $path = $request->file("picture")->storeAs('/'. auth()->user()->id, $fileNameToStore, 'picture_uploads');
            $path = $request->file("picture")->storeAs('/',$fileNameToStore, 'picture_uploads');

        }else{
            $fileNameToStore = "no_image.png";
        }

        // Chek if the profil exists
        // If yes update it else create it
        // this avoids dulpilcated profiles        ;

        $profil = Profil::where('user_id', auth()->user()->id)->get();
        
        if(is_null($profil) || sizeof($profil) == 0){
            $profil = new Profil;
        }else{
            // Another profile is being created for the same user prevent that
            return redirect()->route('create_profile')->with('error', 'operation not allowed!');
        }    

        // I forced the id to solve an unknown problem !!
        $profil->id = auth()->user()->id; 


        $profil->user_id = auth()->user()->id; 
        // $profil->birthday = $request["birthday"];
        $profil->birthday = $birthday;
        $profil->sex_id = $request["sex"];
        $profil->height = $request["height"];
        $profil->relocate = $request["relocate"];
        $profil->haschildren = $request["haschildren"];
        $profil->volunteering = $request["volunteering"];
        $profil->statusincanada_id = $request["status_in_canada"];
        $profil->location_id = $request["location"];
        $profil->maritalstatus_id = $request["marital_status"];
        $profil->howmanychildren_id = $request["howmanychildren"];
        $profil->childrenwithyou_id = $request["childrenwithyou"];
        $profil->education_id = $request["education"];
        $profil->bodytype_id = $request["body_type"];
        $profil->dress_id = $request["dress"];
        $profil->profession_id = $request["profession"];
        // $profil->phone = $request["phone"];
        $profil->phone = $phone;
        $profil->ethnicity_id = $request["ethnicity"];
        $profil->countrygrewup_id = $request["country_grew_up"];



        
        $date_start = date("Y-m-d");
        $date = strtotime($date_start);
            

        $date_end = strtotime('+ 1 year', $date);
        $date_end = date("Y-m-d", $date_end);

        $profil->membership_start = $date_start;
        $profil->membership_end =  $date_end;

        
        $profil->save();


        // Add the picture
        $picture = new Picture;
        $picture->profil_id = $profil->id;
        $picture->picture =  $fileNameToStore;
        $picture->is_main =  1;
        $picture->save();
        


        // Add description
        $description = new SelfDescription;
        $description->profil_id  = $profil->id;
        $description->description  = $request["self_description"];
        $description->save(); 
        // Add What you are looking for
        $lookingfor =  new lookingFor;
        $lookingfor->profil_id  = $profil->id;
        $lookingfor->what_want  = $request["looking_for"];
        $lookingfor->save();
        // Add the hobbies and the Languages
        $profil->hobbies()->sync($request['hobbies'], true);
        $profil->languages()->sync($request['languages'], true);

        $user = User::find(auth()->user()->id);
        $user->status_id = 2; //Waiting for interview
        $user->update();


        
        
        // Send email to admin 
        $total_waiting_for_interview = User::where("status_id", 2)->count();

        $title =  $user->name.' has regitred and is waiting for a interview';
        $content ='User\'s email: '.$user->email;
        $total_waiting_for_interview = "Total number of users waiting for interviews: ".$total_waiting_for_interview;
        
        \Mail::send('mail.registration', ['title' => $title, 'total_waiting_for_interview'=> $total_waiting_for_interview, 'content' => $content], function ($message) use($title)
        {

            $message->from('me@gmail.com', 'Tayeboon2tayebat admin');
            $message->subject('Tayeboon2tayebat: '.$title);
            $message->to('tayeboon2tayebat@gmail.com');

        });


        
        return redirect()->route("my_profile")->with("success", "Congratulations your profile has been created successfully!");
    }//END :  Store function transfer to profile in the future
    
    // --------------------------------------------------------------------
    // Get my profile 
    // --------------------------------------------------------------------
    public function my_profile(){

        $profile = Profil::find(auth()->user()->profile->id);
        
         
        // Unseen matched me
        $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
        // dd($n_unseen_matched_me);
        $n_unseen_both_matched = $this->how_many_both_matched_not_seen();

        // Get the ids of the users whose messages have not been read
        $users_unread_messages = $this->unread_messages();

        // Get picture
        $picture = Picture::where("profil_id", $profile->id)
                ->where("is_main", 1)->first()->picture;
        
                
        // Get payments
        $payments = Payment::where('user_id', auth()->user()->id)->orderBy('payment_date', 'desc')->get(['payment_date']);
        $expiration = Payment::where('user_id', auth()->user()->id)->orderBy('payment_date', 'desc')->first(['expiration_date']);


        return view('profiles.get_profile', ['profile'=>$profile, 
        
        // 'auth_matched'=>$me_matched, 'current_matched'=>$other_matched, 'flagged'=>$flagged, 

        'payments'=>$payments, 'expiration'=>$expiration,
        'n_unseen_matched_me'=>$n_unseen_matched_me, 'n_unseen_both_matched'=>$n_unseen_both_matched,
        'users_unread_messages' => $users_unread_messages,
        'picture'=>$picture]);



    }
    
    
    // --------------------------------------------------------------------
    // Get profile by ID
    // --------------------------------------------------------------------
    public function get_profile($id){
        // check if id is equal to connected id

        
        $profile = "";        
        $profile = Profil::find($id);
        
        // If profile doesn't exist or the user of the same sexe as the logged user
        // Return to the search page with message
        if (is_null($profile) || ($profile->sex->id == auth()->user()->profile->sex->id && $profile->id != auth()->user()->profile->id)){
            return redirect()->route('all_active_users')->with("error", 'You are not allowed to access this profile!');
        }
             
        
        // For admin interview
        if(auth()->user()->role_id<3){
            $interview = Interview::where('profil_id', $profile->id)->first();
            if(is_null( $interview )){
                return view('profiles.get_profile', ['profile'=>$profile]);
            }
            return view('profiles.get_profile', ['profile'=>$profile, 'interview_report'=>$interview]);
        }else{
            // Get matching            
            $me_matched=null;
            $other_matched=null;
            

            // Check if logged user has already matched
            $me_matched = Matching::where('user_1','=',auth()->user()->profile->id)
            ->where('user_2', $id)->first();                
            if(!is_null($me_matched)){
                $me_matched=1;
            }
            // Check if the user of the visted profile has matched
            $other_matched = Matching::where('user_2','=',auth()->user()->profile->id)
            ->where('user_1', $id)->first();
            if(!is_null($other_matched)){
                $other_matched=1;
            }

            // Check if the logged user has flagged the current user 
            // to be canceled the flag must not be seen by admin
            $flagged = flag::where('flagged', $id)
                        ->where('admin_check', 0)->first();
            if(!is_null($flagged)){
                $flagged = 1;
            }

            // Unseen matched me
            $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
            // dd($n_unseen_matched_me);
            $n_unseen_both_matched = $this->how_many_both_matched_not_seen();

            // Get the ids of the users whose messages have not been read
            $users_unread_messages = $this->unread_messages();

            // Get picture
            $picture = Picture::where("profil_id", $profile->id)
                    ->where("is_main", 1)->pluck("picture")[0];
                
            
            return view('profiles.get_profile', ['profile'=>$profile, 'auth_matched'=>$me_matched, 'current_matched'=>$other_matched, 'flagged'=>$flagged, 
            // 'payments'=>$payments, 'expiration'=>$expiration, 
            'n_unseen_matched_me'=>$n_unseen_matched_me, 'n_unseen_both_matched'=>$n_unseen_both_matched,
            'users_unread_messages' => $users_unread_messages,
            'picture'=>$picture]);
        }      


    }// END: Get profile by ID


    // --------------------------------------------------------------------
    // Get pictures
    // --------------------------------------------------------------------
    public function profilePicture($profile_id, $picture_link)
    {
        // $storagePath = storage_path('/profile_pictures/pictures/'.$picture_link);
        // $storagePath = Storage::disk('picture_uploads')->get($profile_id."/".$picture_link);
        
        $storagePath = Storage::disk('picture_uploads')->get($picture_link);
        // dd($full);
        // if($full == 1){
        //     return Image::make($storagePath)->response();
        // }
        return Image::make($storagePath)->resize(400, 400)->response();
        // voir comment formatter l'image avant soumission


    }// END: Get pictures

    public function fullPicture($profile_id, $picture_link)
    {
        // $storagePath = storage_path('/profile_pictures/pictures/'.$picture_link);
        // $storagePath = Storage::disk('picture_uploads')->get($profile_id."/".$picture_link);
        
        $storagePath = Storage::disk('picture_uploads')->get($picture_link);
        
        return Image::make($storagePath)->response();
    }// END: Get pictures



    //--------------------------------------------------------
    // Return the page that allows to update the profile before interview
    // -------------------------------------------------------
    public function edit_profile()  
    {       
        // after version 1.66 install image reformat with composer
        $profile = Profil::findOrFail(auth()->user()->profile->id);
        $year = date("Y", strtotime($profile->birthday));
        $month = date("m", strtotime($profile->birthday));        
        $day = date("d", strtotime($profile->birthday) + 3600);
        $profile['year'] = $year;
        $profile['month'] = $month;
        $profile['day'] = $day;

        // Get different portions of phone
        $phone = explode("-",$profile->phone);
        $profile['phone-first-three'] = $phone[0];
        $profile['phone-second-three'] = $phone[1];
        $profile['phone-last-four'] = $phone[2];
        
        $profile_infos = $this->information_loader();

        return view('profiles.edit_profile', $profile_infos)->with("profile", $profile);
        
    }

    // --------------------------------------------------------------------    
    // Store the informations of the profile 
    // --------------------------------------------------------------------
    public function update_profile(Request $request){
        

        // Entry validation
        $request->validate([
            // 'birthday' => 'required',
            'year'=> 'required',
            'month'=> 'required',
            'day'=>'required',
            'phone-first-three'=>'required',
            'phone-second-three'=>'required',
            'phone-four'=>'required',
            // 'sex' => 'required', No sex
            'relocate' => 'required',
            'haschildren'=>'required',
            'status_in_canada'=>'required',
            'marital_status'=>'required',
            'location'=>'required',
            'education'=>'required',
            'body_type'=>'required',
            'dress'=>'required',
            'profession'=>'required',
            'self_description'=>'required',
            'looking_for'=>'required',            
        ])  ;  
            
        // Validating phone number
        $phone = "";        
        if(strlen($request['phone-first-three']) == 3 && strlen($request['phone-second-three']) == 3 && strlen($request['phone-four']) == 4){
            $phone = $request['phone-first-three']."-".$request['phone-second-three']."-".$request['phone-four'];
            
        }
        if($phone===""){
            return redirect()->back()->with("error", "The phone number you provided is invalid. A valid phone number must be xxx-xxx-xxxx (x is a digit between 0 an 9).");
        }    

        // Check if age is lower than 18yo 
        $birthday =  $request['year']."-".$request['month']."-".$request['day'];        
        $age = (strtotime(date('Y-m-d')) - strtotime($birthday))/(3600*24*365);
        

        if($age<18){
            return redirect()->back()->with('error','You must be at least 18 years old to use this website!');
        }


        $profil = Profil::where('user_id', auth()->user()->id)->first();
        // Do not allow change of Sex
        $sex = $profil->sex_id;

        // $profil->picture = $fileNameToStore;
        $profil->user_id = auth()->user()->id;
        // $profil->birthday = $request["birthday"];
        $profil->birthday = $birthday;
        $profil->sex_id = $sex;
        $profil->height = $request["height"];
        $profil->relocate = $request["relocate"];
        $profil->haschildren = $request["haschildren"];
        $profil->volunteering = $request["volunteering"];
        $profil->statusincanada_id = $request["status_in_canada"];
        $profil->location_id = $request["location"];
        $profil->maritalstatus_id = $request["marital_status"];
        $profil->howmanychildren_id = $request["howmanychildren"];
        $profil->childrenwithyou_id = $request["childrenwithyou"];
        $profil->education_id = $request["education"];
        $profil->bodytype_id = $request["body_type"];
        $profil->dress_id = $request["dress"];
        $profil->profession_id = $request["profession"];
        $profil->phone = $phone;
        $profil->ethnicity_id = $request["ethnicity"];
        $profil->countrygrewup_id = $request["country_grew_up"];       
        
        
        $profil->update();

        // Add description
        $description =  SelfDescription::where("profil_id", $profil->id)->first();
        $description->profil_id  = $profil->id;
        $description->description  = $request["self_description"];
        $description->update();
        // Add What you are looking for
        $lookingfor =  lookingFor::where("profil_id", $profil->id)->first();
        $lookingfor->profil_id  = $profil->id;
        $lookingfor->what_want  = $request["looking_for"];
        $lookingfor->update();

        // Add the hobbies and the Languages
        $profil->hobbies()->sync($request['hobbies'], true);
        $profil->languages()->sync($request['languages'], true);       



        return redirect()->route("my_profile" )->with("success", "Your profile has been updated succefully!");
    }//END :  Store function transfer to profile in the future


    // ----------------------------
    // Delete account
    // ----------------------------

    public function remove_my_account(Request $request){

        $id = $request['logged_user'];
        // Check if the logged user is the same as the one who wants to delete the account
        if(auth()->user()->profile->id == $id){            
            $user= User::findOrFail($id);
            // Check if the password is correct
            if (\Hash::check($request['password'], $user->password)){   
                
                // Remove pictures
                $pictures_paths = Picture::where("profil_id", $id)->get(['picture'])->toarray(); 
                $pictures = Picture::where("profil_id", $id);
                
                    // Remove the files frm storage
                    foreach($pictures_paths as $pp){
                        Storage::disk('picture_uploads')->delete($pp);
                    }

                    // Remove records from database
                    $pictures->delete();

                
                // Remove all discussions
                $messages = Message::where("user_1", $id)
                ->orWhere("user_2", $id);                
                $messages->delete();

                // Remove all matchings
                $matchings = Matching::where("user_1", $id)
                ->orWhere("user_2", $id);                
                $matchings->delete();

                // Remove all payments records
                $payments = Payment::where("user_id", $user->id);            
                $payments->delete();

                // Remove description
                $description =  SelfDescription::where("profil_id", $id)->delete();   
                // Add What you are looking for
                $lookingfor =  lookingFor::where("profil_id", $id)->delete();
                
                // Remove profile
                $profile = Profil::findOrFail($id);
                $profile->delete();

                // Remove from Flag
                $flag = Flag::where("flagging", $id)
                ->orWhere("flagged", $id);
                $flag->delete();

                // Remove feedbacks
                $fb = Feedback::where('user_id', $id);
                $fb->delete();
                
                 // Send email to the user
                $email = $user->email;

                $title = 'Account removal';
                $content = 'Your account has been successfully removed from tayeboon 2 tayebat. Thank you for using tayeboon 2 tayebat website.';
                
                \Mail::send('mail.account_activation', ['title' => $title,  'content' => $content], function ($message) use($title, $email)
                {
                
                    $message->from('me@gmail.com', 'Tayeboon2tayebat admin');
                    $message->subject('Tayeboon2tayebat: '.$title);
                    $message->to($email);
        
                });


                // Delete user
                $user->delete();                

                // Logout the user
                auth()->logout();



                return redirect()->route('welcome')->with('success', 'Your account has been deleted successfully, thank you for using tayeboon 2 tayebat website.');
            }
            else{                
                return redirect()->back()->with('error', 'The password you entered doesn\'t match our records, please try again!');
            } 
        }else{
            return redirect()->back()->with('error','Operation not allowed!');
        }


    }


}
