<?php

namespace App\Actions;

use App\Aggregates\UserAggregate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('landlord.users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        $userAggregate = UserAggregate::retrieve($user->uuid);

        if (isset($input['photo'])) {
            DB::transaction(function () use ($user, $input, $userAggregate) {
                $user->updateProfilePhoto($input['photo']);

                $userAggregate->updateUserProfile(
                    name: $input['name'],
                    email: $input['email'],
                    profilePhotoPath: $user->profile_photo_path
                )->persist();
            });
        } else {
            $userAggregate->updateUserProfile(
                name: $input['name'],
                email: $input['email']
            )->persist();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
