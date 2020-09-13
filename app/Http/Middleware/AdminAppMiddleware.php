<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class AdminAppMiddleware
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
        if (!empty(session()->get('admin.app'))) {
            return $next($request);
        }
        return redirect()->route('admin.error');
    }
}
