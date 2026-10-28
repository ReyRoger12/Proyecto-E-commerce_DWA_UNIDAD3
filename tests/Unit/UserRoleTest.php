<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\Usuario;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function test_defines_the_three_available_roles(): void
    {
        $this->assertSame(
            ['administrador', 'gerente', 'cliente'],
            array_column(UserRole::cases(), 'value'),
        );
    }

    public function test_user_casts_the_role_to_an_enum(): void
    {
        $usuario = new Usuario;
        $usuario->setAttribute('rol', 'administrador');

        $this->assertSame(UserRole::Administrator, $usuario->rol);
    }

    #[DataProvider('roleDashboards')]
    public function test_each_role_resolves_its_dashboard(UserRole $role, string $route): void
    {
        $this->assertSame($route, $role->dashboardRoute());
    }

    public static function roleDashboards(): array
    {
        return [
            'administrador' => [UserRole::Administrator, 'administrador.dashboard'],
            'gerente' => [UserRole::Manager, 'gerente.dashboard'],
            'cliente' => [UserRole::Client, 'cliente.dashboard'],
        ];
    }
}
