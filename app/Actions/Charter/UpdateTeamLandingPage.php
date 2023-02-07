<?php

namespace App\Actions\Charter;

use App\Contracts\UpdatesTeamLandingPage;
use Illuminate\Support\Facades\DB;
use Validator;

class UpdateTeamLandingPage implements UpdatesTeamLandingPage
{
    public function update($team, array $input)
    {
        // Validator::make($input, [
        //     'landing_page' => ['nullable', 'mimes:text/html'],
        // ])->validateWithBag('updateLandingPage');

        // dd($input);

        if (isset($input['landing_page'])) {
            DB::transaction(function () use ($team, $input) {
                $team->updateLandingPage($input['landing_page']);
            });
        }
    }
}
