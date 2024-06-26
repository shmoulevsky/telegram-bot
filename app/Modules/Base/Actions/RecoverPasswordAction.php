<?php

namespace App\Modules\Base\Actions;

use App\Modules\Base\Dto\SuccessResponseDto;
use App\Modules\Base\Dto\RecoverPasswordDto;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RecoverPasswordAction
{
    public function execute(RecoverPasswordDto $dto): SuccessResponseDto
    {
        $dto->user->update(
            [
                'password' => Hash::make($dto->password),
                'hash_password_recovery' => null,
            ]
        );

        return new SuccessResponseDto();
    }
}
