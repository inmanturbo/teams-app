<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController as LivewireTeamController;
use Laravel\Jetstream\Jetstream;

class TeamController extends LivewireTeamController
{
    /**
     * Show the team management screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->where('uuid', $teamId)->firstOrFail();

        if (Gate::denies('view', $team)) {
            abort(403);
        }

        return view('teams.show', [
            'user' => $request->user(),
            'team' => $team,
        ]);
    }

    /**
     * Show the team creation screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Jetstream::newTeamModel());

        return view('teams.create', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Show the team creation screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function createFirstTeam(Request $request)
    {
        return view('teams.create-first-team', [
            'user' => $request->user(),
        ]);
    }

    public function joinTeam(Request $request)
    {
        return view('teams.invitations', [
            'user' => $request->user(),
        ]);
    }
}
