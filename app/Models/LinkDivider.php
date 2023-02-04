<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkDivider extends Link
{
    use HasFactory;
    use HasParent;

    public function label() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => '|',
            set: fn ($value, $attributes) => '|',
        );
    }

    public function url() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => '#' . ltrim($value, '#'),
            set: fn ($value, $attributes) => '#' . ltrim($value, '#'),
        );
    }
}
