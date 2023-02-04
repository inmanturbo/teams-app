<?php

namespace App\Aggregates;

use App\StorableEvents\SearchCreated;
use App\StorableEvents\SearchUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class SearchAggregate extends AggregateRoot
{
    public function createSearch(
        string $searchableUuid,
        string $searchableType,
        string $name,
        ?string $userUuid = null
    ) {
        $this->recordThat(new SearchCreated(
            $this->uuid(),
            $name,
            $searchableUuid,
            $searchableType,
            $userUuid
        ));

        return $this;
    }

    public function updateSearch(
        string $name,
        ?string $term = null,
        ?string $operator = null,
        ?string $key = null,
        ?string $driver = null,
        ?string $description = null,
        ?string $rawQuery = null,
        ?string $type = null
    ) {
        $this->recordThat(new SearchUpdated(
            $this->uuid(),
            name: $name,
            term: $term,
            operator: $operator,
            key: $key,
            driver: $driver,
            description: $description,
            rawQuery: $rawQuery,
            type: $type
        ));

        return $this;
    }
}
