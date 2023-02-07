<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserTypeUpdated extends ShouldBeStored
{
    public function __construct(
        public string $userUuid,
        public string $userType,
    ) {
    }
}
