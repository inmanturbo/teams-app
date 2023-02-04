<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserSwitchedTeam extends ShouldBeStored
{
    public function __construct(
        public string $userUuid,
        public string $teamUuid,
    ) {
    }
}
