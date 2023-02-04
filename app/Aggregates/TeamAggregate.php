<?php

namespace App\Aggregates;

use App\StorableEvents\TeamCreated;
use App\StorableEvents\TeamDataUpdated;
use App\StorableEvents\TeamDeleted;
use App\StorableEvents\TeamDomainUpdated;
use App\StorableEvents\TeamMemberAdded;
use App\StorableEvents\TeamMemberInvited;
use App\StorableEvents\TeamMemberRemoved;
use App\StorableEvents\TeamNameUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class TeamAggregate extends AggregateRoot
{
    public function createTeam(
        string $ownerUuid,
        string $name,
        string $teamDatabaseUuid,
        ?bool $personalTeam = false,
    ) {
        $this->recordThat(new TeamCreated(
            teamUuid: $this->uuid(),
            name: $name,
            ownerUuid: $ownerUuid,
            teamDatabaseUuid: $teamDatabaseUuid,
            personalTeam: $personalTeam,
        ));

        return $this;
    }

    public function addMember(
        string $teamUuid,
        string $email,
        string $role,
    ) {
        $this->recordThat(new TeamMemberAdded(
            teamUuid: $teamUuid,
            email: $email,
            role: $role,
        ));

        return $this;
    }

    public function deleteTeam()
    {
        $this->recordThat(new TeamDeleted(
            teamUuid: $this->uuid(),
        ));

        return $this;
    }

    public function inviteTeamMember(
        string $email,
        string $role,
        string $invitationUuid,
    ) {
        $this->recordThat(new TeamMemberInvited(
            teamUuid: $this->uuid(),
            email: $email,
            role: $role,
            invitationUuid: $invitationUuid,
        ));

        return $this;
    }

    public function removeTeamMember(
        string $teamMemberUuid,
    ) {
        $this->recordThat(new TeamMemberRemoved(
            teamUuid: $this->uuid(),
            teamMemberUuid: $teamMemberUuid,
        ));

        return $this;
    }

    public function updateTeamName(
        string $name,
    ) {
        $this->recordThat(new TeamNameUpdated(
            teamUuid: $this->uuid(),
            name: $name,
        ));

        return $this;
    }

    public function updateTeamDomain(
        string|null $domain,
    ) {
        $this->recordThat(new TeamDomainUpdated(
            teamUuid: $this->uuid(),
            domain: $domain,
        ));

        return $this;
    }

    public function updateTeamData(
        array $teamData,
    ) {
        $this->recordThat(new TeamDataUpdated(
            teamUuid: $this->uuid(),
            teamData: $teamData,
        ));

        return $this;
    }
}
