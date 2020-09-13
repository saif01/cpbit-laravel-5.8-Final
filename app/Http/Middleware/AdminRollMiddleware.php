<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class AdminRollMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$roll)
    {
        if ( !empty(session()->get('admin.'.$roll)) ) {

            if(session()->get('admin.'.$roll) == 1 ){
                return $next($request);
            }else{
                return redirect()->route('admin.error');
            }

        }
        return redirect()->route('admin.error');
    }
}
