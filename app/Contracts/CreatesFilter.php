<?php

namespace App\Contracts;

interface CreatesFilter
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $model
     * @param  array  $input
     * @return void
     */
    public function create($user, array $input);
}
