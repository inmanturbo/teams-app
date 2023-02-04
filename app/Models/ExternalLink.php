<?php

namespace App\Models;

use App\Concerns\GetsCleanUrlPath;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExternalLink extends Link
{
    use HasFactory;
    use HasParent;
    use GetsCleanUrlPath;

    public function url() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => $value,
            set: fn ($value, $attributes) => $value,
        );
    }
}
