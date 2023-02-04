<?php

namespace App\Http\Middleware;

use App\Charter;
use Closure;
use Illuminate\Http\Request;

class EnsureTeamForDomain
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
        Charter::ensureTeamForDomain($request);

        return $next($request);
    }
}
