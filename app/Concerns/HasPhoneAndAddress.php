<?php

namespace App\Concerns;

use App\Models\Address;
use App\Models\Phone;

trait HasPhoneAndAddress
{
    public function addresses()
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    public function phones()
    {
        return $this->morphToMany(Phone::class, 'phoneable');
    }

    public function phone()
    {
        return $this->hasOne(Phone::class, 'id', 'phone_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'phone_id');
    }
}
