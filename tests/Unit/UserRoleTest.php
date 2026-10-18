<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function test_defines_the_three_available_roles(): void
    {
        $this->assertSame(
            ['cliente', 'empleado', 'gerente'],
            array_column(UserRole::cases(), 'value'),
        );
    }

    public function test_user_casts_the_role_to_an_enum(): void
    {
        $user = new User;
        $user->setAttribute('role', 'empleado');

        $this->assertSame(UserRole::Employee, $user->role);
    }

    #[DataProvider('roleDashboards')]
    public function test_each_role_resolves_its_dashboard(UserRole $role, string $route): void
    {
        $this->assertSame($route, $role->dashboardRoute());
    }

    public static function roleDashboards(): array
    {
        return [
            'cliente' => [UserRole::Client, 'cliente.dashboard'],
            'empleado' => [UserRole::Employee, 'empleado.dashboard'],
            'gerente' => [UserRole::Manager, 'gerente.dashboard'],
        ];
    }
}
