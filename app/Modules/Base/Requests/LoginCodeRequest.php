<?php

namespace App\Modules\Base\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Base\Rules\LoginRule;

class LoginCodeRequest extends ApiRequest
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
            'code' => ['required', 'string', 'digits:6'],
        ];
    }

    public function attributes()
    {
        return [
            'code' => __("validation.auth.code"),
        ];
    }

}
