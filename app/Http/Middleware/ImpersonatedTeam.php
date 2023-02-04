<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Lab404\Impersonate\Services\ImpersonateManager;

class ImpersonatedTeam
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
        if ($request->user() && $request->user()->isImpersonated()) {
            $impersonator = ($manager = app(ImpersonateManager::class))->getImpersonator();
            $user = request()->user();
            $impersonatorTeam = $impersonator->currentTeam;
            $membership = \App\Charter::membershipInstance($impersonatorTeam, $user);

            if (Gate::forUser($impersonator)->denies('impersonate', $membership)) {
                $manager->leave();
                $this->banner(_('You do not have permission to impersonate this user'), 'danger');
            }

            if (! $user->switchTeam($impersonator->currentTeam)) {
                abort(403);
            }

            if (! $request->session()->has('impersonated_team_uuid')) {
                $request->session()->put('impersonated_team_uuid', $user->currentTeam->uuid);
                $request->session()->put('impersonated_team_name', $user->currentTeam->name);
            }
        }

        return $next($request);
    }

    public function banner(string $message, string $style = 'success')
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $style);
    }
}
