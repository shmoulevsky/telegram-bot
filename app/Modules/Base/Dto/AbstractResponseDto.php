<?php

namespace App\Modules\Base\Dto;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractResponseDto implements Responsable
{
    public function __construct(
        public int $status = Response::HTTP_OK,
        public ?array $data = [],
    )
    {
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json(
            [
                'status' => $this->status,
                'data' => $this->data,
            ],
            $this->status,
        );
    }
}
