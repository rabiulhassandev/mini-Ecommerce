<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserStatusRestrictionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (\auth()->user()->status->id == 1 or \auth()->user()->status->id == 3) {
            return \redirect()->route('user.user-block');
        }
        return $next($request);
    }
}
