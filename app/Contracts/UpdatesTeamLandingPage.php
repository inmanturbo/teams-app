<?php

namespace App\Contracts;

interface UpdatesTeamLandingPage
{
    /**
     * Validate and save the given landing page.
     *
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($team, array $input);
}
