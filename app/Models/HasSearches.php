<?php

namespace App\Models;

trait HasSearches
{
    public function searches()
    {
        return $this->morphToMany(Search::class, 'searchable', 'searchables', 'searchable_uuid', 'search_uuid', 'uuid', 'uuid')
            ->withPivot('user_uuid')
            ->withTimestamps()
            ->as('search');
    }
}
