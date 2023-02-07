<?php

namespace App;

class ExternalIframePath extends AbsolutePath
{
    public string $iframePath;

    protected string $prefix;

    protected string $externalLinkQuery;

    public function __construct(string $path)
    {
        $this->prefix = config('iframes.external_iframe_prefix');

        $this->externalLinkQuery = config('iframes.external_link_key') . $this->getCleanUrl($path);

        $this->iframePath = '/' . $this->prefix .'/'. $this->externalLinkQuery;
    }
}
