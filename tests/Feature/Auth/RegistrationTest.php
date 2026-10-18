<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_registration_page_is_available_to_guests(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('Crear cuenta');
    }

    public function test_new_accounts_are_registered_as_clients(): void
    {
        $response = $this->post('/register', [
            'name' => 'Ana López',
            'email' => '  ANA@EXAMPLE.COM ',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'gerente',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $user = User::query()->where('email', 'ana@example.com')->firstOrFail();

        $this->assertSame('Ana López', $user->name);
        $this->assertSame(UserRole::Client, $user->role);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    public function test_registration_rejects_incomplete_data(): void
    {
        $response = $this->from('/register')->post('/register', []);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertGuest();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_an_existing_email(): void
    {
        User::factory()->create(['email' => 'ana@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Otra Ana',
            'email' => 'ana@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->assertDatabaseCount('users', 1);
    }
}
