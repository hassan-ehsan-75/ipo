<?php

namespace App\Http\Middleware;

use App\UserRole;
use Closure;

class CreateBankBranchRole
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
        if(!UserRole::hasRole(auth()->user()->role_id,'create_branch'))
            return redirect('/home');
        return $next($request);
    }
}
