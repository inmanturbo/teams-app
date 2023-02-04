<?php

namespace App\Models;

enum LinkMenu: string
{
    case NavigationMenu = 'navigation-menu';
    case UserDropdown = 'user-dropdown';

    public function prettyName(): string
    {
        switch ($this) {
            case LinkMenu::UserDropdown:
                return 'Avatar Dropdown only';

                break;
            default:
                return 'Navigation Menu';
        }
    }
}
