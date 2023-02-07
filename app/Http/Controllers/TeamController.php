<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController as LivewireTeamController;
use Laravel\Jetstream\Jetstream;

class TeamController extends LivewireTeamController
{
    /**
     * Show the team management screen.
     */
    public function show(Request $request, int $teamId): View
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
     */
    public function create(Request $request): View
    {
        Gate::authorize('create', Jetstream::newTeamModel());

        return view('teams.create', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Show the team creation screen.
     */
    public function createFirstTeam(Request $request): View
    {
        return view('teams.create-first-team', [
            'user' => $request->user(),
        ]);
    }

    public function joinTeam(Request $request): Response
    {
        return view('teams.invitations', [
            'user' => $request->user(),
        ]);
    }
}
