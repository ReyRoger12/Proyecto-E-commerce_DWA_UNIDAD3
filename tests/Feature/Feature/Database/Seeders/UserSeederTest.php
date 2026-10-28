<?php

namespace Tests\Feature\Database\Seeders;

use App\Enums\UserRole;
use App\Models\Usuario;
use Database\Seeders\UsuarioSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserSeederTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_creates_one_account_for_each_role_and_can_run_twice(): void
    {
        $this->seed(UsuarioSeeder::class);
        $this->seed(UsuarioSeeder::class);

        $this->assertDatabaseCount('usuarios', 4);

        $expectedRoles = [
            'jlopez@tuxtla.tecnm.mx' => UserRole::Administrator,
            'msanchez@tuxtla.tecnm.mx' => UserRole::Manager,
            'mhernandez@tuxtla.tecnm.mx' => UserRole::Client,
            'pmartinez@tuxtla.tecnm.mx' => UserRole::Client,
        ];

        foreach ($expectedRoles as $email => $role) {
            $usuario = Usuario::query()->where('correo', $email)->firstOrFail();

            $this->assertSame($role, $usuario->rol);
            $this->assertTrue(Hash::check('123', $usuario->clave));
        }
    }
}
