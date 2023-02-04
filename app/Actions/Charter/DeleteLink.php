<?php

namespace App\Actions\Charter;

use App\Aggregates\LinkAggregate;
use App\Contracts\DeletesLink;
use App\Models\Link;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class DeleteLink implements DeletesLink
{
    /**
     * Delete the given model.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  string $uuid
     * @return void
     */
    public function delete($user, $uuid)
    {
        $link = Link::where('uuid', $uuid)->firstOrFail();

        Gate::forUser($user)->authorize('delete', $link);

        Validator::make(['uuid' => $uuid], [
            'uuid' => 'required|exists:landlord.links,uuid',
        ])->validate();

        $linkAggregate = LinkAggregate::retrieve($link->uuid);


        $linkAggregate->deleteLink(
            userUuid: $user->uuid,
            teamUuid: $user->currentTeam->uuid,
        )->persist();
    }

    public function redirectTo()
    {
        return route('dashboard');
    }
}
