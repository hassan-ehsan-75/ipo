<?php

namespace App\Http\Middleware;

use App\UserRole;
use Closure;

class CreateCompanyRole
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
        if(!UserRole::hasRole(auth()->user()->role_id,'create_company'))
            return redirect('/companies');
        return $next($request);
    }
}
