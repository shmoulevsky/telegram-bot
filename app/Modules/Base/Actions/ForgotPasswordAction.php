<?php

namespace App\Modules\Base\Actions;

use App\Modules\Base\Dto\SuccessResponseDto;
use App\Modules\User\Models\User;
use App\Notifications\UserForgotPasswordNotification;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordAction
{
    public function execute(User $user): SuccessResponseDto
    {
        $hash = hash('xxh3', $user->email . now()->toString());
        $user->update([
            'hash_password_recovery' => $hash,
        ]);
        $user->notify(new UserForgotPasswordNotification($user));
        return new SuccessResponseDto(
            status: Response::HTTP_OK,
        );
    }
}
