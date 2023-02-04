<?php

namespace App\Contracts;

interface CreatesSearch
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function create($user, array $input);
}
