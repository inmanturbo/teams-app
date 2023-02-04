<?php

namespace App\Actions;

use App\Aggregates\TeamAggregate;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return mixed
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        Validator::make($input, [
            'name' => ['required', 'string','unique:landlord.teams,name', 'max:255'],
            'team_database_uuid' => ['required', 'exists:landlord.team_databases,uuid'],
            'uuid' => ['nullable'],
        ])->validateWithBag('createTeam');

        /**
         * moved to projector
         */
        // AddingTeam::dispatch($user);

        $uuid = Str::uuid();

        TeamAggregate::retrieve($uuid)->createTeam(
            ownerUuid: $user->uuid,
            name: $input['name'],
            teamDatabaseUuid: $input['team_database_uuid']
        )->persist();

        return $user->fresh()->currentTeam;
    }

    public function redirectTo()
    {
        return route('teams.show', Auth::user()->fresh()->currentTeam->uuid);
    }
}
