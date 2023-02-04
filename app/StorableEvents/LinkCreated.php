<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class LinkCreated extends ShouldBeStored
{
    public function __construct(
        public string $linkUuid,
        public string $teamUuid,
        public string $url,
        public ?string $role = null,
        public ?string $userUuid = null,
        public ?string $type = null,
        public ?string $target = null,
        public ?string $title = null,
        public ?string $label = null,
        public ?string $view = null,
        public ?string $icon = null,
        public ?int $orderColumn = null,
        public ?bool $active = true,
    ) {
    }
}
