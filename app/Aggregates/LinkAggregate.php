<?php

namespace App\Aggregates;

use App\StorableEvents\LinkCreated;
use App\StorableEvents\LinkDeleted;
use App\StorableEvents\LinkUpdated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class LinkAggregate extends AggregateRoot
{
    public function createLink(
        string $teamUuid,
        string $url,
        ?string $role = null,
        ?string $userUuid = null,
        ?string $type = null,
        ?string $target = null,
        ?string $title = null,
        ?string $label = null,
        ?string $view = null,
        ?string $icon = null,
        ?int $orderColumn = null,
        ?bool $active = true,
    ) {
        $this->recordThat(new LinkCreated(
            $this->uuid(),
            teamUuid:  $teamUuid,
            userUuid:  $userUuid,
            role:  $role,
            type:  $type,
            target:  $target,
            url:  $url,
            title:  $title,
            label:  $label,
            view:  $view,
            icon:  $icon,
            orderColumn:  $orderColumn,
            active:  $active,
        ));

        return $this;
    }

    public function updateLink(
        ?string $teamUuid = null,
        ?string $url = null,
        ?string $role = null,
        ?string $userUuid = null,
        ?string $type = null,
        ?string $target = null,
        ?string $title = null,
        ?string $label = null,
        ?string $view = null,
        ?string $icon = null,
        ?int $orderColumn = null,
        ?bool $active = true,
    ) {
        $this->recordThat(new LinkUpdated(
            $this->uuid(),
            teamUuid:  $teamUuid,
            userUuid:  $userUuid,
            role:  $role,
            type:  $type,
            target:  $target,
            url:  $url,
            title:  $title,
            label:  $label,
            view:  $view,
            icon:  $icon,
            orderColumn:  $orderColumn,
            active:  $active,
        ));

        return $this;
    }

    public function deleteLink(
        string $teamUuid,
        string $userUuid,
    ) {
        $this->recordThat(new LinkDeleted(
            $this->uuid(),
            teamUuid:  $teamUuid,
            userUuid:  $userUuid,
        ));

        return $this;
    }
}
