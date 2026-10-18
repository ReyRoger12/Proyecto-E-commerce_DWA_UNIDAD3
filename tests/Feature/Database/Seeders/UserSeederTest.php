<?php

namespace Tests\Feature\Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserSeederTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_creates_one_account_for_each_role_and_can_run_twice(): void
    {
        $this->seed(UserSeeder::class);
        $this->seed(UserSeeder::class);

        $this->assertDatabaseCount('users', 3);

        $expectedRoles = [
            'cliente@tienda.test' => UserRole::Client,
            'empleado@tienda.test' => UserRole::Employee,
            'gerente@tienda.test' => UserRole::Manager,
        ];

        foreach ($expectedRoles as $email => $role) {
            $user = User::query()->where('email', $email)->firstOrFail();

            $this->assertSame($role, $user->role);
            $this->assertTrue(Hash::check('password', $user->password));
        }
    }
}
