<?php

namespace App\Modules\Base\Rules;

use App\Modules\User\Models\User;
use App\Modules\Base\Rules\Helpers\LoginRuleHelper;
use Illuminate\Contracts\Validation\Rule;

class RecoverPasswordRule implements Rule
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
        return User::where('email', $value['email'])
            ->where('hash_password_recovery', $value['hash'])
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Несоответствие хэша и e-mail пользователя';
    }
}
