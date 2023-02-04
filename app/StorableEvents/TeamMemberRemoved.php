<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class TeamMemberRemoved extends ShouldBeStored
{
    public function __construct(
        public string $teamUuid,
        public string $teamMemberUuid,
    ) {
    }
}
