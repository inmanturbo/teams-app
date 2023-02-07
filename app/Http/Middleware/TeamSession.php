<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (isset(app()['team'])) {
            if (! $request->session()->has('team_uuid')) {
                $request->session()->put('team_uuid', app('team')->uuid);
            }

            if ($request->session()->get('team_uuid') !== app('team')->uuid && ! $request->user()->switchTeam(app('team'))) {
                abort(401);
            }
        }

        return $next($request);
    }
}
