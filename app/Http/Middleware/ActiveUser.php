<?php

namespace App\Http\Middleware;

use Closure;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)    
    {

        // if (auth()->user()->status->status != "Active") {
        //     return redirect()->route('get_profile', auth()->user()->profile->id)->with('error', 'Please make sure your account active in order to access the requested page');
        // }
        if(auth()->user()->role->id == 3){
            if(auth()->user()->status_id == 3){
                return $next($request);
            }
            else if(auth()->user()->status_id == 1){ //Just refistered
                return redirect()->route('create_profile');                
            }
            else if(auth()->user()->status_id == 2){ //Waiting for interview
                return redirect()->route('my_profile')->with('error', 'Your account is not yet active, you cannot access this functionality!');                
            }
            else if(auth()->user()->status_id == 4){
                return redirect()->route('expired_account');
            }
            else if(auth()->user()->status_id == 5){
                return redirect()->route('banned_account');
            }
        }
        else if(auth()->user()->role->id < 3){
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->route('home');
        }
        
    }
}
