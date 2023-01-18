<?php

namespace App\Http\Middleware;

use App\UserRole;
use Closure;

class ViewBankRole
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
        if(!UserRole::hasRole(auth()->user()->role_id,'view_bank'))
            return redirect('/home');
        return $next($request);
    }
}
