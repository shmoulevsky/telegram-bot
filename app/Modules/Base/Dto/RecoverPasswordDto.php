<?php

namespace App\Modules\Base\Dto;

use App\Modules\User\Models\User;

class RecoverPasswordDto
{
    public function __construct(
        public User $user,
        public string $password,
    )
    {
    }
}
