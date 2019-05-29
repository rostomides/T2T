<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminUserMiddleware
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
        
        // If an operator tries to perform operation->redirect to dashboard
        if (auth()->user()->role_id == 2) {
            return redirect()->route('dashboard')->with('error', 'Unknown operation!');
        }
        // If  a client tries to perform operation->redirect to his profile
        else if(auth()->user()->role_id == 3){
            return redirect()->route('my_profile')->with('error', 'Unknown operation!');
        }
        else if(auth()->user()->role_id == 1){
            return $next($request);
        }else{
            return redirect()->route('welcome');
        }


        
    }
}
