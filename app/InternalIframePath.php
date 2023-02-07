<?php

namespace App;

class InternalIframePath extends AbsolutePath
{
    public string $iframePath;

    protected string $prefix;

    public function __construct(string $path)
    {
        parent::__construct($path);
        $this->prefix = config('iframes.internal_iframe_prefix');
        $this->iframePath = '/'.$this->prefix . $this->absolutePath;
    }
}
