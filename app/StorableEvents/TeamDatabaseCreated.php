<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class TeamDatabaseCreated extends ShouldBeStored
{
    public function __construct(
        public string $databaseUuid,
        public string $userUuid,
        public string $name,
        public ?string $driver = null,
    ) {
    }
}
