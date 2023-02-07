<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Contracts\UpdatesCurrentTeam;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Jetstream\Jetstream;

class CurrentTeamController extends Controller
{
    /**
     * Update the authenticated user's current team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatesCurrentTeam $updater, Request $request): RedirectResponse
    {
        $team = Jetstream::newTeamModel()->whereUuid($request->team_uuid)->firstOrFail();

        $updater->update($request->user(), ['team_uuid' => $team->uuid]);

        $previousPath = parse_url(url()->previous(), PHP_URL_PATH);

        return redirect($team->url ? $team->url . $previousPath : config('landlord.url') . config('fortify.home'), 303);
    }
}
