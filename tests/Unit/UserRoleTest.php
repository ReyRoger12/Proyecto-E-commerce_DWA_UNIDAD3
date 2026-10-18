<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\User;
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
}
