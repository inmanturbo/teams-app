<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class TeamMemberAdded extends ShouldBeStored
{
    public function __construct(
        public string $teamUuid,
        public string $email,
        public string $role,
    ) {
    }
}
