<?php

namespace App\Http\Middleware;

use App\UserRole;
use Closure;

class DeleteRole
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
        if(!UserRole::hasRole(auth()->user()->role_id,'delete_role'))
            return redirect('/home');
        return $next($request);
    }
}
