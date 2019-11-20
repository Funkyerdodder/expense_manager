<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $roles = explode('|', $roles);
        if(!Auth::check()) {
            return redirect('/');
        }

        if(Auth::user()->hasAnyRoles($roles)) {
            return $next($request);
        }
        
        return redirect('/dashboard');
    }
}
