<?php

namespace App\Models;

use App\InternalIframePath;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternalIframe extends Link
{
    use HasFactory;
    use HasParent;

    public function url() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => (new InternalIframePath($value))->iframePath,
            set: fn ($value, $attributes) => $value,
        );
    }
}
