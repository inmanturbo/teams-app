<?php

namespace App\Actions;

use App\Aggregates\UserAggregate;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use Fortify\PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:landlord.users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            $uuid = (string) Str::uuid();

            $userAggregate = UserAggregate::retrieve($uuid);

            $userAggregate->createUser(
                name: $input['name'],
                email: $input['email'],
                password: $input['password'],
                withPersonalTeam: false,
            )->persist();

            return User::whereUuid($uuid)->first();
        });
    }
}
