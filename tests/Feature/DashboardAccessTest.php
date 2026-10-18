<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use LazilyRefreshDatabase;

    #[DataProvider('protectedDashboardPaths')]
    public function test_guest_is_sent_to_login_from_protected_dashboards(string $path): void
    {
        $response = $this->get($path);

        $response->assertRedirect('/login');
    }

    #[DataProvider('roleRedirects')]
    public function test_authenticated_user_is_sent_to_the_dashboard_for_their_role(
        UserRole $role,
        string $expectedRoute,
    ): void {
        $user = $this->createUserWithRole($role);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirectToRoute($expectedRoute);
    }

    #[DataProvider('roleDashboards')]
    public function test_user_can_open_the_dashboard_for_their_role(
        UserRole $role,
        string $route,
        string $heading,
    ): void {
        $user = $this->createUserWithRole($role);

        $response = $this->actingAs($user)->get(route($route));

        $response->assertOk();
        $response->assertSee($heading);
        $response->assertSee('Cerrar sesión');
    }

    #[DataProvider('forbiddenDashboards')]
    public function test_user_cannot_open_a_dashboard_for_another_role(
        UserRole $role,
        string $route,
    ): void {
        $user = $this->createUserWithRole($role);

        $response = $this->actingAs($user)->get(route($route));

        $response->assertForbidden();
    }

    public static function protectedDashboardPaths(): array
    {
        return [
            'selector' => ['/dashboard'],
            'cliente' => ['/cliente/dashboard'],
            'empleado' => ['/empleado/dashboard'],
            'gerente' => ['/gerente/dashboard'],
        ];
    }

    public static function roleDashboards(): array
    {
        return [
            'cliente' => [UserRole::Client, 'cliente.dashboard', 'Panel de cliente'],
            'empleado' => [UserRole::Employee, 'empleado.dashboard', 'Panel de empleado'],
            'gerente' => [UserRole::Manager, 'gerente.dashboard', 'Panel de gerente'],
        ];
    }

    public static function roleRedirects(): array
    {
        return [
            'cliente' => [UserRole::Client, 'cliente.dashboard'],
            'empleado' => [UserRole::Employee, 'empleado.dashboard'],
            'gerente' => [UserRole::Manager, 'gerente.dashboard'],
        ];
    }

    public static function forbiddenDashboards(): array
    {
        return [
            'cliente en panel de empleado' => [UserRole::Client, 'empleado.dashboard'],
            'cliente en panel de gerente' => [UserRole::Client, 'gerente.dashboard'],
            'empleado en panel de cliente' => [UserRole::Employee, 'cliente.dashboard'],
            'empleado en panel de gerente' => [UserRole::Employee, 'gerente.dashboard'],
            'gerente en panel de cliente' => [UserRole::Manager, 'cliente.dashboard'],
            'gerente en panel de empleado' => [UserRole::Manager, 'empleado.dashboard'],
        ];
    }

    private function createUserWithRole(UserRole $role): User
    {
        $factory = match ($role) {
            UserRole::Client => User::factory()->client(),
            UserRole::Employee => User::factory()->employee(),
            UserRole::Manager => User::factory()->manager(),
        };

        return $factory->create();
    }
}
