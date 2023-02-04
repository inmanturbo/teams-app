<?php

namespace App\Actions\Charter;

use App\Aggregates\FilterAggregate;
use App\Contracts\CreatesFilter;
use App\Models\Filter;
use App\Models\StoredQuery;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Str;

class CreateFilter implements CreatesFilter
{
    public function create($user, array $input)
    {
        Gate::forUser($user)->authorize('create', StoredQuery::class);

        Validator::make($input, [
            'name' => 'required|string|max:255|unique:stored_queries,name',
            'stored_queryable_type' => 'required|string|max:255',
            'stored_queryable_uuid' => 'required|string|max:255',
        ])->validate();

        $filterAggregate = FilterAggregate::retrieve(Str::uuid());

        $filterAggregate->createFilter(
            name: $input['name'],
            storedQueryableType: $input['stored_queryable_type'],
            storedQueryableUuid: $input['stored_queryable_uuid'],
            userUuid: $user->uuid,
        )->persist();
    }
}
{
}
