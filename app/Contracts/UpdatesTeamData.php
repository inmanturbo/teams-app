<?php

namespace App\Contracts;

interface UpdatesTeamData
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $model
     * @param  array  $input
     * @return void
     */
    public function update($user, $team, array $input);
}
