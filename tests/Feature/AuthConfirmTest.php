<?php

namespace Tests\Feature;

use App\Modules\User\Enums\UserStatusEnum;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * @property \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model $user
 */
class AuthConfirmTest extends TestCase
{
    use DatabaseTransactions;

    private Model $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->create(
            [
                'name' => 'AuthTest',
                'password' => bcrypt('password'),
                'email' => 'auth-check-test@test.ru',
                'phone' => '79929928787',
                'status' => UserStatusEnum::active,
            ]
        );
    }

    public function test_check()
    {
        $login = 'auth-check-test@test.ru';
        $password = 'password';

        $response = $this->post(
            route('login'),
            [
                'login' => $login,
                'password' => $password,
            ]
        );

        $data = json_decode($response->getContent());
        $user = User::query()->where('email', $login)->first();

        $response = $this->post(
            route('user.login.check'),
            [
                'code' => $user->auth_code
            ],
            ['Authorization' => 'Bearer ' . $data->data->token]
        );

        $structure = ['status', 'data' => ['message']];

        $response->assertStatus(200);
        $response->assertJsonStructure($structure);
    }

}
