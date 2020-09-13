<?php

namespace App\Http\Middleware;

use Closure;

class AdminRoomMiddleware
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
        if (!empty(session()->get('admin.room'))) {
            return $next($request);
        }
        return redirect()->route('admin.error');
    }
}
