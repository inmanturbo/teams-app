<?php

namespace App\Models;

enum LinkType: string
{
    case Link = 'link';
    case InternalLink = 'internal_link';
    case ExternalLink = 'external_link';
    case InternalIframe = 'internal_iframe';
    case ExternalIframe = 'external_iframe';
    case LinkDivider = 'link_divider';

    public function prettyName(): string
    {
        switch ($this) {
            case LinkType::InternalLink:
                return 'Local Path (/dashboard)';

                break;
            case LinkType::InternalIframe:
                return 'Local Path in an Iframe';

                break;
            case LinkType::ExternalIframe:
                return 'Full URL in an Iframe';

                break;
            case LinkType::LinkDivider:
                return 'Divider';

                break;
            default:
                return 'URL (http://example.com)';
        }
    }
}
