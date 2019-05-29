<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


// Added
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */



    // Create a new method redirect to
    public function redirectTo(){        
        //User status       
        
        if(Auth::user()->role_id == 3){
            if(Auth::user()->status_id == 1){ //Just refistered
                return route('create_profile');
            }
            else if(Auth::user()->status_id == 2 || Auth::user()->status_id == 3){
                return route('my_profile');
            }else if(Auth::user()->status_id == 4){
                return route('expired_account');
            }
            else if(Auth::user()->status_id == 5){
                return route('banned_account');
            }      
            
        }else if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            return route('dashboard');
        }
    }        



    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
