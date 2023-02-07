<?php

namespace App\Listeners;

use App\Models\Team;
use Lab404\Impersonate\Events\LeaveImpersonation;

class LeaveImpersonationListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(LeaveImpersonation $event)
    {
        $team = Team::where('uuid', session()->get('impersonated_team_uuid'))->firstOrFail();

        $event->impersonated->switchTeam($team);
    }
}
