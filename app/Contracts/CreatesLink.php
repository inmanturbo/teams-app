<?php

namespace App\Contracts;

interface CreatesLink
{
    /**
     * Create a Link.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function create($user, $team, array $input);
}
