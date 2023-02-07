<?php

namespace App\Concerns;

use App\Models\Address;

trait HasAddress
{
    public function addresses()
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'phone_id');
    }
}
