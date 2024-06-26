<?php

namespace App\Modules\Base\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Base\Rules\RecoverPasswordRule;

class RecoverPasswordRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => 'required|string|confirmed',
            'user' => ['required', 'array', new RecoverPasswordRule()],
        ];
    }
}
