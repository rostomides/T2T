<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     // dd(auth()->user()->status->status);
        //     // return redirect('/home');
        //     if(auth()->user()->status->id == 3 ) {// Active user
        //         return redirect('get_profile', auth()->user()->id);
        //     }
        //     else{
        //         return redirect('fill_profile');
        //     }
        // }

        // if (Auth::guard($guard)->check()) {
        //     if(Auth::user()->role_id == 3){
        //         if(Auth::user()->status_id == 1){ //Just refistered
        //             return redirect()->route('create_profile');
        //         }
        //         else if(Auth::user()->status_id > 1){
        //             // return '/get_profile/'.Auth::user()->profile->id;
        //             return redirect()->route('get_profile', Auth::user()->profile->id);
        //         }
        //     }else{
        //         return redirect()->route('dashboard');
        //         // return '/dashboard';
        //     }
        // }


        if (Auth::guard($guard)->check()) {
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

        return $next($request);
    }
}
