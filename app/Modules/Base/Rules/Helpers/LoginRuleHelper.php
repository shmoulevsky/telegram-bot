<?php

namespace App\Modules\Base\Rules\Helpers;

class LoginRuleHelper
{
    public static function loginAsEmailClause(string $value): ?string
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
