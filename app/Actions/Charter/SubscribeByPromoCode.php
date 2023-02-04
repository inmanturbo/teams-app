<?php

namespace App\Actions\Charter;

use App\Aggregates\UserAggregate;
use App\Contracts\SubscribesByPromoCode;

class SubscribeByPromoCode implements SubscribesByPromoCode
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function subscribe($user, array $input)
    {
        if (
            in_array(
                $input['promo_code'],
                config('charter.promo_codes')
            ) &&
            is_null($user->trial_ends_at) ||
            ! $user->onTrial() ||
            $user->trialEndsAt()->isToday()
        ) {
            $userAggregate = UserAggregate::retrieve($user->uuid);
            $userAggregate->subscribeUserByPromoCode($input['promo_code'])->persist();
        }
    }
}
