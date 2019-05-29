<?php

namespace App\Http\Middleware;

use Closure;

class WfeOrActiveUserMiddleware
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

        if(auth()->user()->role_id == 3){
             // If an operator tries to perform operation->redirect to dashboard
            if(auth()->user()->status_id == 3 || auth()->user()->status_id == 2){
                return $next($request);
            }
            else if(auth()->user()->status_id == 1){ //Just refistered
                return redirect()->route('create_profile');                
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
