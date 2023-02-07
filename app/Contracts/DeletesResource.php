<?php

namespace App\Contracts;

interface DeletesResource
{
    /**
     * Validate and delete the given model.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  string $uuid
     * @return void
     */
    public function delete($user, $uuid);
}
