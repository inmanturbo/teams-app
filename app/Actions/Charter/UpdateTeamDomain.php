<?php

namespace App\Actions\Charter;

use App\Aggregates\TeamAggregate;
use App\Contracts\UpdatesTeamDomains;
use App\Models\UserType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Validator;

class UpdateTeamDomain implements UpdatesTeamDomains
{
    /**
     * Validate and update the given  team's domain.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  array  $input
     * @return void
     */
    public function update($user, $team, array $input): void
    {
        Gate::forUser($user)->authorize('update', $team);

        $restrictedDomains = config('charter.restricted_domains', []);

        $appDomain = parse_url(config('app.url'))['host'] ?? '';

        $restrictedDomains[] = auth()->user()->type == UserType::SuperAdmin ? 'google.com' : $appDomain;

        Validator::make($input, [
            'domain' => ['nullable', 'string',Rule::unique(config('landlord.db_connection').'.teams')->ignore($team->uuid, 'uuid'), 'max:255', 'not_in:'.implode(',', $restrictedDomains)],
        ])->validateWithBag('updateTeamDomain');

        $domain = ($input['domain'] && strlen($input['domain']) > 3) ? $input['domain'] : null;

        TeamAggregate::retrieve(
            uuid: $team->uuid
        )->updateTeamDomain(
            domain: $domain
        )->persist();
    }
}
