<?php

namespace App\Actions;

use App\Aggregates\TeamAggregate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;

class UpdateTeamName implements UpdatesTeamNames
{
    /**
     * Validate and update the given  team'sny's name.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     */
    public function update($user, $team, array $input): void
    {
        Gate::forUser($user)->authorize('update', $team);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', Rule::unique(config('landlord.db_connection').'.teams')->ignore($team->uuid, 'uuid')],
        ])->validateWithBag('updateTeamName');

        TeamAggregate::retrieve(
            uuid: $team->uuid
        )->updateTeamName(
            name: $input['name']
        )->persist();
    }
}
