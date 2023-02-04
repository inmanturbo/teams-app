<?php

namespace App\Models;

enum LinkTarget: string
{
    case Blank = '_blank';
    case Self = '_self';
    case Parent = '_parent';
    case Top = '_top';
}
