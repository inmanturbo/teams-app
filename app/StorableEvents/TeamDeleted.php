<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class TeamDeleted extends ShouldBeStored
{
    public function __construct(
        public string $teamUuid,
    ) {
    }
}
