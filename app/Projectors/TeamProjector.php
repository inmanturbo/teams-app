<?php

namespace App\Projectors;

use App\Models\Team;
use App\Models\TeamDatabase;
use App\Models\TeamInvitation;
use App\Models\User;
use App\StorableEvents\TeamDataUpdated;
use App\StorableEvents\TeamCreated;
use App\StorableEvents\TeamDeleted;
use App\StorableEvents\TeamDomainUpdated;
use App\StorableEvents\TeamMemberAdded;
use App\StorableEvents\TeamMemberInvited;
use App\StorableEvents\TeamMemberRemoved;
use App\StorableEvents\TeamNameUpdated;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TeamProjector extends Projector
{
    public function onTeamCreated(TeamCreated $event)
    {
        $user = User::whereUuid($event->ownerUuid)->first();

        $teamDatabase = TeamDatabase::whereUuid($event->teamDatabaseUuid)->firstOrFail();

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'uuid' => $event->teamUuid,
            'name' => $event->name,
            'team_database_id' => $teamDatabase->id,
            'personal_team' => $event->personalTeam,
        ]));
    }

    public function onTeamMemberAdded(TeamMemberAdded $event)
    {
        $team = Team::whereUuid($event->teamUuid)->first();

        $newTeamMember = Jetstream::findUserByEmailOrFail($event->email);

        $team->users()->attach($newTeamMember, ['role' => $event->role]);
    }

    public function onTeamDeleted(TeamDeleted $event)
    {
        $team = Team::whereUuid($event->teamUuid)->first();

        $team->purge();
    }

    public function onTeamMemberInvited(TeamMemberInvited $event)
    {
        $team = Team::whereUuid($event->teamUuid)->firstOrFail();

        // $invitation = TeamInvitation::firtstOrNew(['uuid' => $event->invitationUuid],[
        //     'email' => $event->email,
        //     'role' => $event->role,
        //     'uuid' => $event->invitationUuid,
        // ]);

        $team->teamInvitations()->firstOrCreate(['team_id' => $team->id, 'email' => $event->email], [
            'email' => $event->email,
            'role' => $event->role,
            'uuid' => $event->invitationUuid,
        ]);
    }

    public function onTeamMemberRemoved(TeamMemberRemoved $event)
    {
        $team = Team::whereUuid($event->teamUuid)->first();

        $teamMember = User::whereUuid($event->teamMemberUuid)->first();

        $team->removeUser($teamMember);
    }

    public function onTeamNameUpdated(TeamNameUpdated $event)
    {
        $team = Team::whereUuid($event->teamUuid)->first();

        $team->forceFill([
            'name' => $event->name,
        ])->save();
    }

    public function onTeamDomainUpdated(TeamDomainUpdated $event)
    {
        $team = Team::whereUuid($event->teamUuid)->first();

        $team->forceFill([
            'domain' => $event->domain ,
        ])->save();
    }

    public function onTeamDataUpdated(TeamDataUpdated $event)
    {
        $team = Team::whereUuid($event->teamUuid)->first();

        $team->forcefill([ 'team_data' => $event->teamData])->save();
    }
}
