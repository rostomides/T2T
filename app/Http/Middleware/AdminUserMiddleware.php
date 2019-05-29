<?php

namespace App\Http\Middleware;

use Closure;

class AdminUserMiddleware
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
        
        if (auth()->user()->role_id == 3) {                      
            return redirect()->route('my_profile')->with('error', 'Unknown operation!');
        }
        else if(auth()->user()->role_id  == 1 || auth()->user()->role_id == 2){
            return $next($request);
        }else{
            return redirect()->route('welcome');
        }

        
    }
}
