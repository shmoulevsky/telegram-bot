<?php

namespace App\Modules\User\Enums;

enum UserGroupEnum: string
{
    case user = 'user';
    case admin = 'admin';
    case moderator = 'moderator';
}
