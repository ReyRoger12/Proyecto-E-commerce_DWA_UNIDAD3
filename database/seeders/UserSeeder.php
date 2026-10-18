<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Cliente Demo',
                'email' => 'cliente@tienda.test',
                'role' => UserRole::Client,
            ],
            [
                'name' => 'Empleado Demo',
                'email' => 'empleado@tienda.test',
                'role' => UserRole::Employee,
            ],
            [
                'name' => 'Gerente Demo',
                'email' => 'gerente@tienda.test',
                'role' => UserRole::Manager,
            ],
        ];

        foreach ($users as $data) {
            $user = User::query()->firstOrNew(['email' => $data['email']]);
            $user->name = $data['name'];
            $user->password = 'password';
            $user->role = $data['role'];
            $user->save();
        }
    }
}
