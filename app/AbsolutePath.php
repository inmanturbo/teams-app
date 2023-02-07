<?php

namespace App;

use App\Concerns\GetsCleanUrlPath;

class AbsolutePath
{
    use GetsCleanUrlPath;

    public string $path;

    public string $absolutePath;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->absolutePath = '/' . $this->getCleanUrl($this->path);
    }
}
