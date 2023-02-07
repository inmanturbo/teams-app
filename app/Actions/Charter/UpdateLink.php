<?php

namespace App\Actions\Charter;

use App\Aggregates\LinkAggregate;
use App\Concerns\CleansInput;
use App\Contracts\UpdatesLink;
use App\Models\LinkMenu;
use App\Models\LinkTarget;
use App\Models\LinkType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class UpdateLink implements UpdatesLink
{
    use CleansInput;

    public function update($user, $link, $input)
    {
        Gate::forUser($user)->authorize('update', $link);

        $input = $this->cleanInput($input);

        Validator::make($input, [
            'role' => ['nullable', 'string', 'max:255'],
            'type' => [new Enum(LinkType::class), 'nullable'],
            'target' => [new Enum(LinkTarget::class), 'nullable'],
            'url' => ['required', 'string', 'max:255'],
            'title' => ['string', 'nullable', 'max:255'],
            'label' => ['string', 'nullable', 'max:255'],
            'view' => [new Enum(LinkMenu::class), 'nullable'],
            'icon' => ['exists:' . config('landlord.db_connection') . '.icons,name','string', 'nullable', 'max:255', 'min:2'],
            'team_uuid' => ['nullable', 'string','exists:teams,uuid', 'max:255'],
            'order_column' => ['integer', 'nullable'],
            'active' => ['boolean', 'nullable'],
        ])->validateWithBag('updateLink');

        $linkAggregate = LinkAggregate::retrieve($link->uuid);

        $linkAggregate->updateLink(
            teamUuid: $input['team_uuid'] ?? null,
            role: $input['role'] ?? null,
            type: $input['type'] ?? null,
            target: $input['target'] ?? null,
            url: $input['url'] ?? null,
            title: $input['title'] ?? null,
            label: $input['label'] ?? null,
            view: $input['view'] ?? null,
            icon: $input['icon'] ?? null,
            orderColumn: $input['order_column'] ?? null,
            active: $input['active'] ?? true,
        )->persist();
    }
}
