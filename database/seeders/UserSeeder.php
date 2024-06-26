<?php

namespace Database\Seeders;

use App\Modules\User\Enums\UserGroupEnum;
use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(__DIR__ . '/data/users.json');
        $users = (json_decode($data, true));

        foreach ($users as $user){

            $userItem = User::firstOrCreate(
                [
                    'phone' => $user['phone'],
                    'email' => $user['email'],
                ],
                [
                    'status' => $user['status'],
                    'last_name' => $user['last_name'],
                    'name' => $user['name'],
                    'second_name' => $user['second_name'],
                    'password' => Hash::make($user['password']),
                    'hash' => md5($user['email']),
                    'is_admin' => $user['is_admin'] ?? false,
                    'group' => $user['group'] ?? UserGroupEnum::user->value,
                ]
            );



        }

    }

}
