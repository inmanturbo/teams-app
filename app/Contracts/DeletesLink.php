<?php

namespace App\Contracts;

interface DeletesLink extends DeletesResource
{
    /**
     * Validate and delete the given model.
     *
     * @param  mixed  $user
     * @param  mixed  $uuid
     * @return void
     */
    public function delete($user, $uuid);
}
