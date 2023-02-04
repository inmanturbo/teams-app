<?php

namespace App\Aggregates;

use App\StorableEvents\TeamDatabaseCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class TeamDatabaseAggregate extends AggregateRoot
{
    public function createTeamDatabase(
        string $userUuid,
        string $name,
        ?string $driver = null,
    ) {
        $this->recordThat(
            new TeamDatabaseCreated(
                databaseUuid: $this->uuid(),
                userUuid: $userUuid,
                name: $name,
                driver: $driver,
            )
        );

        return $this;
    }
}
