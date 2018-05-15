<?php

namespace App\Http\Middleware;

use App\Facades\Staff;
use Closure;

class StaffLogged
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
        if (!Staff::isLogged()){
            return redirect(route('_login'));
        }
        return $next($request);
    }
}
