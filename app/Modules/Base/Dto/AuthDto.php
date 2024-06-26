<?php

namespace App\Modules\Base\Dto;

use App\Modules\User\Models\User;

class AuthDto
{
    public function __construct(
        public ?User $user,
        public string $password,
    )
    {
    }
}
