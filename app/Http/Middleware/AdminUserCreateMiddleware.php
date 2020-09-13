<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminUserCreateMiddleware
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
        if (!empty(session()->get('admin.user_cr'))) {
            return $next($request);
        }
        return redirect()->route('admin.error');
    }
}
