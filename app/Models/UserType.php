<?php

namespace App\Models;

enum UserType: string
{
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case UpgradedUser = 'upgraded_user';
    case User = 'user';
    case Guest = 'guest';
}
