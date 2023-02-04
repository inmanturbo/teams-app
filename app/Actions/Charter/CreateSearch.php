<?php

namespace App\Actions\Charter;

use App\Aggregates\SearchAggregate;
use App\Contracts\CreatesSearch;
use App\Models\Search;
use App\Models\Searchable;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Str;

class CreateSearch implements CreatesSearch
{
    /**
     * Validate and save the given model.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', Search::class);

        Validator::make($input, [
            'name' => 'required|string|max:255,unique:searches,name',
            'searchable_uuid' => 'required|string|max:36',
            'searchable_type' => 'required|string|max:255',
        ])->validate();

        $searchAggregate = SearchAggregate::retrieve(Str::uuid());

        $searchAggregate->createSearch(
            searchableUuid:  $input['searchable_uuid'],
            searchableType:  $input['searchable_type'],
            name:  $input['name'],
            userUuid:  $user->uuid,
        )->persist();
    }
}
