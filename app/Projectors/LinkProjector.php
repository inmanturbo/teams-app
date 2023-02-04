<?php

namespace App\Projectors;

use App\Models\Link;
use App\Models\LinkType;
use App\Models\Team;
use App\Models\User;
use App\StorableEvents\LinkCreated;
use App\StorableEvents\LinkDeleted;
use App\StorableEvents\LinkUpdated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class LinkProjector extends Projector
{
    public function onLinkCreated(LinkCreated $event)
    {
        $teamId = (Team::where('uuid', $event->teamUuid)->first())->id ?? null;
        $userId = (User::where('uuid', $event->userUuid)->first())->id ?? null;

        $data = [
            'uuid' => $event->linkUuid,
            'team_id' => $teamId,
            'user_id' => $userId,
            'type' => $event->type ?? LinkType::InternalLink->value,
            'target' => $event->target,
            'url' => $event->url,
            'title' => $event->title,
            'label' => $event->label,
            'role' => $event->role,
            'view' => $event->view,
            'icon' => $event->icon,
            'active' => $event->active,
        ];

        $link = Link::forceCreate($data);

        if ($event->orderColumn) {
            $this->moveOrderUpOrDown($link, $event->orderColumn);
        }
    }

    public function onLinkUpdated(LinkUpdated $event)
    {
        $link = Link::where('uuid', $event->linkUuid)->first();

        $data = [
            'team_id' => (Team::where('uuid', $event->teamUuid)->first())->id ?? $link->team_id,
            'user_id' => (User::where('uuid', $event->userUuid)->first())->id ?? $link->user_id,
            'type' => $event->type,
            'target' => $event->target,
            'url' => $event->url,
            'title' => $event->title,
            'label' => $event->label,
            'role' => $event->role,
            'view' => $event->view,
            'icon' => $event->icon,
            'active' => $event->active,
        ];

        $link->forceFill($data)->save();

        if ($event->orderColumn) {
            $this->moveOrderUpOrDown($link, $event->orderColumn);
        }
    }

    public function onLinkDeleted(LinkDeleted $event)
    {
        $link = Link::where('uuid', $event->linkUuid)->first();
        $link->delete();
    }

    protected function moveOrderUpOrDown($link, $eventOrderColumn)
    {
        if ($eventOrderColumn && $eventOrderColumn != $link->order_column) {
            //move link to new position
            if ($eventOrderColumn > $link->order_column) {
                for ($i = $link->order_column; $i < $eventOrderColumn; $i++) {
                    $link->moveOrderDown();
                }
            } else {
                for ($i = $link->order_column; $i > $eventOrderColumn; $i--) {
                    $link->moveOrderUp();
                }
            }
        }
    }
}
