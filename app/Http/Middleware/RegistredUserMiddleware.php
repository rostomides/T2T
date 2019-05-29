<?php

namespace App\Http\Middleware;

use Closure;

class RegistredUserMiddleware
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
            if(auth()->user()->status_id == 1){
                return $next($request);
            }
            else if(auth()->user()->status_id == 2 || auth()->user()->status_id == 3){ //active or waiting for interview
                return redirect()->route('my_profile');                
            }        
            else if(auth()->user()->status_id == 4){
                return redirect()->route('expired_account');
            }
            else if(auth()->user()->status_id == 5){
                return redirect()->route('banned_account');
            }
        }
        else if(auth()->user()->role_id < 3){
            return redirect()->route('dashboard');
        }         
        else{
            return redirect()->route('home');
        }  
    }
}
