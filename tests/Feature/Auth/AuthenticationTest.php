<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_login_page_is_available_to_guests(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Iniciar sesión');
    }

    public function test_user_can_log_in_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_log_in_with_an_invalid_password(): void
    {
        $user = User::factory()->create(['password' => 'secret123']);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'incorrecta',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'email' => 'El correo o la contraseña no son correctos.',
        ]);
        $this->assertGuest();
    }

    public function test_login_is_blocked_after_five_failed_attempts(): void
    {
        $user = User::factory()->create(['password' => 'secret123']);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', [
                'email' => $user->email,
                'password' => 'incorrecta',
            ]);
        }

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertStringStartsWith(
            'Demasiados intentos.',
            session('errors')->first('email'),
        );
        $this->assertGuest();
    }

    public function test_authenticated_user_can_log_out(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
