<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class UseRoomMiddleware
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
        if (!empty(session()->get('user.room'))) {
            return $next($request);
        }
        return redirect()->route('user.error');
    }
}
