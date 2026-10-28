<?php

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\Usuario;
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
            'nombre' => 'Ana',
            'apellidos' => 'López Pérez',
            'correo' => '  ANA@EXAMPLE.COM ',
            'clave' => 'secret123',
            'clave_confirmation' => 'secret123',
            'rol' => 'gerente',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $usuario = Usuario::query()->where('correo', 'ana@example.com')->firstOrFail();

        $this->assertSame('Ana', $usuario->nombre);
        $this->assertSame('López Pérez', $usuario->apellidos);
        $this->assertSame(UserRole::Client, $usuario->rol);
        $this->assertTrue(Hash::check('secret123', $usuario->clave));
    }

    public function test_registration_rejects_incomplete_data(): void
    {
        $response = $this->from('/register')->post('/register', []);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['nombre', 'apellidos', 'correo', 'clave']);
        $this->assertGuest();
        $this->assertDatabaseCount('usuarios', 0);
    }

    public function test_registration_rejects_an_existing_email(): void
    {
        Usuario::factory()->create(['correo' => 'ana@example.com']);

        $response = $this->from('/register')->post('/register', [
            'nombre' => 'Otra',
            'apellidos' => 'Ana',
            'correo' => 'ana@example.com',
            'clave' => 'secret123',
            'clave_confirmation' => 'secret123',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('correo');
        $this->assertGuest();
        $this->assertDatabaseCount('usuarios', 1);
    }
}
