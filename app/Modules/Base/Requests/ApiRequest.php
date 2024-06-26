<?php

namespace App\Modules\Base\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ApiRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        // все ошибки валидации
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $errors,
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
