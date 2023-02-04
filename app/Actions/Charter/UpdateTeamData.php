<?php

namespace App\Actions\Charter;

use App\AddressData;
use App\Aggregates\TeamAggregate;
use App\TeamData;
use App\Contracts\UpdatesTeamData;
use Illuminate\Support\Facades\Validator;

class UpdateTeamData implements UpdatesTeamData
{
    public function update($user, $team, array $input)
    {
        Validator::make($input, [
            'address.city' => ['nullable', 'string', 'max:255'],
            'address.state' => ['nullable', 'string', 'max:255'],
            'address.zip' => ['nullable', 'string', 'max:255'],
            'address.street' => ['nullable', 'string', 'max:255'],
            'address.country' => ['nullable', 'string', 'max:255'],
            'address.lineTwo' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string'],
            'fax' => ['nullable', 'string'],
        ])->validate();

        $teamData = new TeamData(
            address: new AddressData(
                city: $input['address']['city'] ?? '',
                state: $input['address']['state'] ?? '',
                zip: $input['address']['zip'] ?? '',
                street: $input['address']['street'] ?? '',
                country: $input['address']['country'] ?? '',
                lineTwo: $input['address']['lineTwo'] ?? '',
            ),
            website: $input['website'] ?? null,
            email: $input['email'] ?? null,
            phone: $input['phone'] ?? config('team.empty_phone'),
            fax: $input['fax'] ?? config('team.empty_phone'),
        );

        $teamAggregate = TeamAggregate::retrieve($team->uuid);

        $teamAggregate->updateTeamData(
            teamData: $teamData->toArray()
        )->persist();
    }
}
