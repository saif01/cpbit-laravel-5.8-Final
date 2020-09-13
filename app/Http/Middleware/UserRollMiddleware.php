<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class UserRollMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roll)
    {
        
        if ( !empty(session()->get('user.'.$roll)) ) {

            if(session()->get('user.'.$roll) == 1 ){
                return $next($request);
            }else{
                return redirect('/');
            }

        }
        return redirect('/');
 
    }
}
