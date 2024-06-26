<?php

namespace Tests\Feature;

use App\Modules\User\Enums\UserStatusEnum;
use App\Modules\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        User::query()->create(
            [
                'name' => 'AuthTest',
                'password' => bcrypt('password'),
                'email' => 'auth-test@test.ru',
                'phone' => '79929928787',
                'status' => UserStatusEnum::active,
            ]
        );
    }

    /**
     * A basic feature test example.
     *
     * @dataProvider loginDataProvider
     *
     * @return void
     */
    public function test_user_can_login(string $login, int $status, string $password, array $structure)
    {
        $response = $this->post(
            route('login'),
            [
                'login' => $login,
                'password' => $password,
            ]
        );

        $response->assertStatus($status);
        $response->assertJsonStructure($structure);
    }

    public function loginDataProvider()
    {
        $token = ['status', 'data' => ['token']];
        $message = ['success', 'errors' => ['message']];

        return [
            ['auth-test@test.ru', 200, 'password', $token], //email
            ['auth-test@test.ru', 400, 'wrongpassword', $message], //password wrong
            ['wrongemail@example.org', 404, 'wrongpassword', $message], //email wrong
        ];
    }
}
