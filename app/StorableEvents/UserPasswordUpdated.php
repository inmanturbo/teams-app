<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserPasswordUpdated extends ShouldBeStored
{
    public function __construct(
        public string $userUuid,
        public string $password,
    ) {
    }
}
