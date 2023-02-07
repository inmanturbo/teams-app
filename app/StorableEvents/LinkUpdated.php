<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class LinkUpdated extends ShouldBeStored
{
    public function __construct(
        public string $linkUuid,
        public ?string $teamUuid = null,
        public ?string $userUuid = null,
        public ?string $role = null,
        public ?string $url = null,
        public ?string $title = null,
        public ?string $label = null,
        public ?string $view = null,
        public ?string $icon = null,
        public ?string $type = null,
        public ?string $target = null,
        public ?int $orderColumn = null,
        public ?bool $active = true,
    ) {
    }
}
