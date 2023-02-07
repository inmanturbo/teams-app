<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('team_uuid') && $request->user()) {
            $team = \App\Models\Team::whereUuid($request->team_uuid)->firstOrFail();

            if (! $request->user()->switchTeam($team)) {
                abort(403);
            }
        }

        return $next($request);
    }
}
