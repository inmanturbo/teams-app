<?php

namespace App\Contracts;

interface UpdatesTeamLogo
{
    /**
     * Validate and update the given  team's profile information.
     *
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($team, array $input);
}
