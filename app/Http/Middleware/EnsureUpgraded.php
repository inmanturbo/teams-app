<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;
use Symfony\Component\HttpFoundation\Response;

class EnsureUpgraded
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Gate::denies('create', Jetstream::newTeamModel())) {
            return redirect()->route('create-first-team');
        }

        return $next($request);
    }
}
