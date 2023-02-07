<?php

namespace App\Actions\Charter;

use App\Aggregates\LinkAggregate;
use App\Contracts\CreatesLink;
use App\Models\Link;
use App\Models\LinkMenu;
use App\Models\LinkTarget;
use App\Models\LinkType;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class CreateLink implements CreatesLink
{
    /**
     * Create a Link.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     */
    public function create($user, $team, array $input): void
    {
        Gate::forUser($user)->authorize('create', Link::class);

        Validator::make($input, [
            'role' => ['required', 'string', 'max:255'],
            'type' => [new Enum(LinkType::class), 'nullable'],
            'target' => [new Enum(LinkTarget::class), 'nullable'],
            'url' => ['string', 'nullable', 'max:255'],
            'title' => ['string', 'nullable', 'max:255'],
            'label' => ['string', 'nullable', 'max:255'],
            'view' => [new Enum(LinkMenu::class), 'nullable'],
            'icon' => ['exists:' . config('landlord.db_connection') . '.icons,name', 'nullable'],
            'order_column' => ['integer', 'nullable'],
            'active' => ['boolean', 'nullable'],
        ])->validateWithBag('createLink');

        $uuid = Str::uuid();

        $linkAggregate = LinkAggregate::retrieve($uuid);

        $linkAggregate->createLink(
            teamUuid: $team->uuid,
            userUuid: $user->uuid,
            role: $input['role'],
            type: $input['type'],
            target: $input['target'],
            url: $input['url'],
            title: $input['title'],
            label: $input['label'],
            view: $input['view'] ?? null,
            icon: $input['icon'] ?? null,
            orderColumn: $input['order_column'] ?? null,
            active: $input['active'] ?? true,
        )->persist();
    }

    public function redirectTo()
    {
        session()->flash('flash.banner', 'Link created successfully.');
        session()->flash('flash.bannerStyle', 'success');

        return route('dashboard');
    }
}
