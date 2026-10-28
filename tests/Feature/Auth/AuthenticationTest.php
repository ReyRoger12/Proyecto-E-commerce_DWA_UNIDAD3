<?php

namespace Tests\Feature\Auth;

use App\Models\Usuario;
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
        $usuario = Usuario::factory()->create(['clave' => 'secret123']);

        $response = $this->post('/login', [
            'correo' => $usuario->correo,
            'clave' => 'secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($usuario);
    }

    public function test_user_cannot_log_in_with_an_invalid_password(): void
    {
        $usuario = Usuario::factory()->create(['clave' => 'secret123']);

        $response = $this->from('/login')->post('/login', [
            'correo' => $usuario->correo,
            'clave' => 'incorrecta',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors([
            'correo' => 'El correo o la contraseña no son correctos.',
        ]);
        $this->assertGuest();
    }

    public function test_login_is_blocked_after_five_failed_attempts(): void
    {
        $usuario = Usuario::factory()->create(['clave' => 'secret123']);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->post('/login', [
                'correo' => $usuario->correo,
                'clave' => 'incorrecta',
            ]);
        }

        $response = $this->post('/login', [
            'correo' => $usuario->correo,
            'clave' => 'secret123',
        ]);

        $response->assertSessionHasErrors('correo');
        $this->assertStringStartsWith(
            'Demasiados intentos.',
            session('errors')->first('correo'),
        );
        $this->assertGuest();
    }

    public function test_authenticated_user_can_log_out(): void
    {
        $usuario = Usuario::factory()->create();

        $response = $this->actingAs($usuario)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
