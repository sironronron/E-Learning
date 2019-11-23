<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckInstructor
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
        // if (Auth::user()->role_id != 3) {
        //     return response()->json(['error' => 'You have to be an instructor man.'], 403);
        // }
        return $next($request);
    }
}
