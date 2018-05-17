<?php

namespace App\Http\Middleware;

use App\Facades\Staff;
use Closure;

class StaffLoggedRoot
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
        if (!Staff::isRoot()) {
            flash_error(trans('part.text_permission'));
            return redirect(route('_dashboard'));
        }
        return $next($request);
    }
}
