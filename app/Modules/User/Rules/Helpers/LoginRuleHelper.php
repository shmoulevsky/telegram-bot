<?php

namespace App\Modules\User\Rules\Helpers;

use App\Modules\User\Models\User;

class LoginRuleHelper
{
    public static function loginAsEmailClause(string $value): ?string
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
