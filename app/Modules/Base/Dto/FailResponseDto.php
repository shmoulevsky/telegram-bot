<?php

namespace App\Modules\Base\Dto;

use Illuminate\Contracts\Support\Responsable;

class FailResponseDto implements Responsable
{
    public function __construct(
        public string $status,
        public array $errors
    )
    {

    }

    public function toResponse($request)
    {
        return response()->json(
            [
                'success' => false,
                'errors' => $this->errors,
            ],
            $this->status,
        );
    }
}
