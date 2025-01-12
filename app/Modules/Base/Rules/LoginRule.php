<?php

namespace App\Modules\Base\Rules;

use App\Modules\Base\Rules\Helpers\LoginRuleHelper;
use Illuminate\Contracts\Validation\Rule;

class LoginRule implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (LoginRuleHelper::loginAsEmailClause($value)) {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Неверный E-mail.';
    }
}
