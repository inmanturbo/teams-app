<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Contracts\UpdatesCurrentTeam;
use App\Models\TeamInvitation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Jetstream;

class TeamInvitationController
{
    /**
     * Accept a team invitation.
     */
    public function accept(Request $request, TeamInvitation $invitation): RedirectResponse
    {
        if ($request->user()->email !== $invitation->email) {
            session()->flash('flash.banner', 'This invitation is for another email address.');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect()->back();
        }

        app(AddsTeamMembers::class)->add(
            $invitation->team->owner,
            $invitation->team,
            $invitation->email,
            $invitation->role
        );

        $user = Jetstream::findUserByEmailOrFail($invitation->email);

        app(UpdatesCurrentTeam::class)->update($user, [ 'team_uuid' => $invitation->team->uuid ]);

        $invitation->delete();

        return redirect($invitation->team->url . config('fortify.home'))->banner(
            __('Great! You have accepted the invitation to join the :team team.', ['team' => $invitation->team->name]),
        );
    }

    /**
     * Cancel the given team invitation.
     */
    public function destroy(Request $request, TeamInvitation $invitation): RedirectResponse
    {
        if (! Gate::forUser($request->user())->check('removeTeamMember', $invitation->team)) {
            throw new AuthorizationException;
        }

        $invitation->delete();

        return back(303);
    }
}
