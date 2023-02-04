<?php

namespace App\Contracts;

interface UpdatesLink
{
    /**
     * Validate and save the given link.
     *
     * @param  mixed  $user
     * @param  mixed  $link
     * @param  array  $input
     * @return void
     */
    public function update($user, $link, array $input);
}
