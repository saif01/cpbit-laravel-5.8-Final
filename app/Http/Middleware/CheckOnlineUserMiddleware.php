<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Illuminate\Support\Carbon;
use Session;

class CheckOnlineUserMiddleware
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

        if(session()->get('user.id')){
            $expireAt = Carbon::now()->addMinutes(5);
            Cache::put('user-is-online'. session()->get('user.id'), true, $expireAt );
        }
        return $next($request);

    }
}
