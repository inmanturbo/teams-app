<?php

namespace App\Actions\Charter;

use App\Aggregates\UserAggregate;
use App\Contracts\SubscribesByPromoCode;
use Illuminate\Support\Facades\Validator;

class SubscribeByPromoCode implements SubscribesByPromoCode
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     */
    public function subscribe($user, array $input): void
    {
        $validPromoCodes = array_filter(config('charter.promo_codes'));

        Validator::make($input, [
            'promo_code' => ['required', 'string', 'max:255'],
        ])->after(function ($validator) use ($input, $validPromoCodes, $user) {
            if (! in_array($input['promo_code'], $validPromoCodes)) {
                $validator->errors()->add('state.promo_code', 'Invalid Promo Code');
            }
            if (
                ($user->trial_ends_at || $user->onTrial()) &&
                ! $user->trialEndsAt()->isToday()
            ) {
                $validator->errors()->add('state.promo_code', 'You are already subscribed, you can renew your subscription on ' . $user->trialEndsAt()->format('m-d-Y')  . '.');
            }
        })->validateWithBag('subscribeByPromoCode');

        $userAggregate = UserAggregate::retrieve($user->uuid);
        $userAggregate->subscribeUserByPromoCode($input['promo_code'])->persist();
    }
}
