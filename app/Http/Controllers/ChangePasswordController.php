<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
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
use App\Flag;

use App\Traits\my_traits;


class ChangePasswordController extends Controller
{

    // ----
    use my_traits; // This is an important line for the trait to be loaded
    // ----




    // ---------------------
    // Return the password reset page
    // ---------------------

    public function index(){
        // If the user is a non amin
        if(auth()->user()->role_id ==3 && in_array(auth()->user()->status_id, Array(2,3)) ){
            $n_unseen_matched_me = $this->how_many_matched_me_not_seen();
            $return_data['n_unseen_matched_me']  = $n_unseen_matched_me;

            $n_unseen_both_matched = $this->how_many_both_matched_not_seen();
            $return_data['n_unseen_both_matched']  = $n_unseen_both_matched;

            // Get the ids of the users whose messages have not been read
            $users_unread_messages = $this->unread_messages();
            $return_data['users_unread_messages']  = $users_unread_messages;

            return view('change_password.change_password',$return_data)->with(['name'=>auth()->user()->name]);
        }
        else if (auth()->user()->role_id <3){
            return view('change_password.change_password', $this->common_values())->with(['name'=>auth()->user()->name]); 
        }else{
            return redirect()->route('welcome');
        }
        
    }



    // ---------------------
    // Store the new password
    // ---------------------
    public function store_new_password(Request $request){

        $request->validate([
            'name' => 'required',
            'current_password' => 'required',            
            'password' => 'required|string|min:6|confirmed',
        ])  ; 

        // If the user is a non amin
        if((auth()->user()->role_id ==3 && in_array(auth()->user()->status_id, Array(2,3)))  || auth()->user()->role_id <3){

            $user = User::findorFail(auth()->user()->id); 
            
            if (Hash::check($request['current_password'], $user->password)){  
                $user->name = $request['name']  ;
                $user->password = Hash::make($request['password']);
                $user->update();                
                return redirect()->route('change_password')->with('success', 'Your password has been reset successfully');                 
            }
            else{                
                return redirect()->route('change_password')->with('error', 'Your current password is not valid!');
            }       
            
        }else{
            return redirect()->route('welcome');
        }
        
    }








    // common values to work with in dashboard
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
}
