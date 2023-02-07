<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class LinkDeleted extends ShouldBeStored
{
    public function __construct(
        public string $linkUuid,
        public string $teamUuid,
        public string $userUuid
    ) {
    }
}
