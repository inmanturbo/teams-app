<?php

namespace App\Contracts;

interface SubscribesByPromoCode
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function subscribe($user, array $input);
}
