<?php

namespace App\Actions\Charter;

use App\Contracts\UpdatesTeamLogo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateTeamLogo implements UpdatesTeamLogo
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($team, array $input)
    {
        Validator::make($input, [
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            DB::transaction(function () use ($team, $input) {
                $team->updateProfilePhoto($input['photo']);
            });
        }
    }
}
