<?php

namespace App\Http\Livewire;

use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager as JetstreamTeamMemberManager;
use Laravel\Jetstream\Jetstream;

class TeamMemberManager extends JetstreamTeamMemberManager
{
    /**
     * Add a new team member to a team.
     *
     * @return void
     */
    public function addTeamMember()
    {
        $this->resetErrorBag();

        if (Features::sendsTeamInvitations()) {
            app(InvitesTeamMembers::class)->invite(
                $this->user,
                $this->team,
                $this->addTeamMemberForm['email'],
                $this->addTeamMemberForm['role']
            );
        } else {
            app(AddsTeamMembers::class)->add(
                $this->user,
                $this->team,
                $this->addTeamMemberForm['email'],
                $this->addTeamMemberForm['role']
            );
        }

        $this->addTeamMemberForm = [
            'email' => '',
            'role' => null,
        ];

        $this->team = $this->team->fresh();

        $this->emit('saved');
    }

    /**
     * Remove a team member from the team.
     *
     * @param  \Laravel\Jetstream\Contracts\RemovesTeamMembers  $remover
     * @return void
     */
    public function removeTeamMember(RemovesTeamMembers $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $user = is_numeric($this->teamMemberIdBeingRemoved) ?
            Jetstream::findUserByIdOrFail($this->teamMemberIdBeingRemoved) :
            Jetstream::newUserModel()->where('uuid', $this->teamMemberIdBeingRemoved)->firstOrFail(),
        );

        $this->confirmingTeamMemberRemoval = false;

        $this->teamMemberIdBeingRemoved = null;

        $this->team = $this->team->fresh();
    }

    /**
     * Cancel a pending team member invitation.
     *
     * @param  int  $invitationId
     * @return void
     */
    public function cancelTeamInvitation($invitationId)
    {
        if (! empty($invitationId)) {
            $model = Jetstream::teamInvitationModel();

            $model::whereKey($invitationId)->orWhere('uuid', $invitationId)->delete();
        }

        $this->team = $this->team->fresh();
    }

    /**
     * Remove the currently authenticated user from the team.
     *
     * @param  \Laravel\Jetstream\Contracts\RemovesTeamMembers  $remover
     * @return void
     */
    public function leaveTeam(RemovesTeamMembers $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $this->user
        );

        $this->confirmingLeavingTeam = false;

        $this->team = $this->team->fresh();

        $this->banner(_('You are no longer a member of this team.'), 'danger');

        return to_route('join-team');
    }

    public function banner(string $message, string $style = 'success')
    {
        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $style);
    }
}
