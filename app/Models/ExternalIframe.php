<?php

namespace App\Models;

use App\ExternalIframePath;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExternalIframe extends Link
{
    use HasFactory;
    use HasParent;

    public function url() : Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => (new ExternalIframePath($value))->iframePath,
            set: fn ($value, $attributes) => $value,
        );
    }
}
