<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class TeamDomainUpdated extends ShouldBeStored
{
    public function __construct(
        public string $teamUuid,
        public string|null $domain
    ) {
    }
}
