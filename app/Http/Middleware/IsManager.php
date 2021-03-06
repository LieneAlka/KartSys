<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsManager
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
        $group = Auth::user()->group_id;
        if($group != '1') {

            return redirect()->route('home');
        }
        return $next($request);
    }
}
