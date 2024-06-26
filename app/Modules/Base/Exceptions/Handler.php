<?php

namespace App\Modules\Base\Exceptions;

use App\Dto\Response\FailResponseDto;
use App\Modules\Utils\Log\DTO\LogDTO;
use App\Modules\Utils\Log\Services\LogService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e){
            $userId = auth('sanctum')->id() ?? Auth::id() ?? null;
            $logDTO = LogDTO::fromException($e, $userId);
            $logService = app()->make(LogService::class);
            $logService->logFile($logDTO, 'common');
            $logService->logDB($logDTO);
        });
    }
}
