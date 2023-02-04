<?php

namespace App\Actions;

use App\Aggregates\TeamAggregate;
use Laravel\Jetstream\Contracts\DeletesTeams;

class DeleteTeam implements DeletesTeams
{
    /**
     * Delete the given team.
     *
     * @param  mixed  $team
     * @return void
     */
    public function delete($team)
    {
        TeamAggregate::retrieve($team->uuid)->deleteTeam()->persist();
    }
}
