<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class TeamDataUpdated extends ShouldBeStored
{
    public function __construct(
        public $teamUuid,
        public array $teamData,
    ) {
    }
}
