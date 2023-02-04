<?php

namespace App\Actions\Charter;

use App\Aggregates\UserAggregate;
use App\Contracts\UpdatesUserType;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class UpdateUserType implements UpdatesUserType
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $model
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Gate::forUser($user)->authorize('updateUserType', User::class);

        Validator::make($input, [
            'user_type' => [ new Enum(UserType::class), 'required'],
        ])->validate();

        $userAggregate = UserAggregate::retrieve($user->uuid);

        $userAggregate->updateUserType(
            type: $input['user_type'],
        )->persist();
    }
}
