<?php

namespace App\Modules\Base\Actions;

use App\Modules\Base\Dto\SuccessResponseDto;
use App\Modules\Base\Dto\AuthDto;
use App\Modules\Base\Exceptions\AuthWrongCredentialsException;
use App\Modules\Base\Exceptions\UserNotFoundException;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthAction
{
    /**
     * @throws AuthWrongCredentialsException
     * @throws UserNotFoundException
     */
    public function execute(AuthDto $dto): SuccessResponseDto
    {
        if (! $dto->user) {
            throw new UserNotFoundException(
                'Неверный логин или пароль',
                Response::HTTP_NOT_FOUND
            );
        }

        if (!Hash::check($dto->password, $dto->user->password)) {
            throw new AuthWrongCredentialsException(
                'Неверный логин или пароль',
                Response::HTTP_BAD_REQUEST
            );
        }
        $dto->user->generateTwoFactorCode();
        $dto->user->notify(new TwoFactorCodeNotification());
        $token = $dto->user->createToken($dto->user->email . $dto->user->created_at)->plainTextToken;

        return new SuccessResponseDto(
            status: Response::HTTP_OK,
            data: [
                'token' => $token,
            ],
        );
    }
}
