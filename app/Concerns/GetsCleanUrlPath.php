<?php

namespace App\Concerns;

trait GetsCleanUrlPath
{
    public $dirtyUriSegments = [

    ];

    protected function getCleanUrl(string $value)
    {
        return ltrim(str_replace(array_values(config('charter.dirty_url_segments', [])), '', $value), '/');
    }
}
