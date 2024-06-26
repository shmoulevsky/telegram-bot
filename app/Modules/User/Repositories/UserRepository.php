<?php

namespace App\Modules\User\Repositories;

use App\Modules\Base\Repositories\BaseRepository;
use App\Modules\User\Models\User;
use App\Modules\User\Rules\Helpers\LoginRuleHelper;
use App\Modules\User\Services\PhoneService;

class UserRepository extends BaseRepository
{

    private PhoneService $phoneService;

    public function __construct()
    {
        $this->model = new User();
        $this->phoneService = new PhoneService();
    }

    public function getByEmailPhone(string $login)
    {
        $phone = $this->phoneService->parse($login);

        return User::where(function ($query) use ($login, $phone){
            $query->where('email', $login);
            $query->orWhere('phone', $phone);
        })->first();
    }

    public function getUserByLogin(string $value)
    {
        $login = LoginRuleHelper::loginAsEmailClause($value);
        return User::query()->whereRaw("LOWER(email)='".mb_strtolower($login)."'")->first();
    }

}
