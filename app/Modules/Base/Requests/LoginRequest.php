<?php

namespace App\Modules\Base\Requests;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Base\Rules\LoginRule;

class LoginRequest extends ApiRequest
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
            'login' => ['required', 'string', new LoginRule()],
            'password' => ['required', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'login' => __("validation.auth.login"),
            'password' => __("validation.auth.password"),
        ];
    }

}
