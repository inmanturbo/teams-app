<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class UserPromoCodeEntered extends ShouldBeStored
{
    public function __construct(
        public string $userUuid,
        public string $promoCode,
    ) {
    }
}
