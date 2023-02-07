<?php

namespace App\Contracts;

interface UpdatesUserType
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input);
}
