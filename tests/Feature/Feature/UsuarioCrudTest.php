<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UsuarioCrudTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_administrador_puede_gestionar_usuarios(): void
    {
        $administrador = Usuario::factory()->administrador()->create();

        $this->actingAs($administrador)->post(route('usuarios.store'), [
            'nombre' => 'Pedro',
            'apellidos' => 'Martinez',
            'correo' => 'pmartinez.nuevo@tuxtla.tecnm.mx',
            'clave' => '123',
            'clave_confirmation' => '123',
            'rol' => UserRole::Client->value,
        ])->assertRedirect();

        $usuario = Usuario::query()
            ->where('correo', 'pmartinez.nuevo@tuxtla.tecnm.mx')
            ->firstOrFail();

        $this->actingAs($administrador)->put(route('usuarios.update', $usuario), [
            'nombre' => 'Pedro',
            'apellidos' => 'Martinez Gomez',
            'correo' => 'pmartinez.nuevo@tuxtla.tecnm.mx',
            'clave' => '',
            'clave_confirmation' => '',
            'rol' => UserRole::Manager->value,
        ])->assertRedirect(route('usuarios.show', $usuario));

        $this->assertDatabaseHas('usuarios', [
            'id' => $usuario->id,
            'apellidos' => 'Martinez Gomez',
            'rol' => UserRole::Manager->value,
        ]);

        $this->actingAs($administrador)
            ->delete(route('usuarios.destroy', $usuario))
            ->assertRedirect(route('usuarios.index'));

        $this->assertDatabaseMissing('usuarios', ['id' => $usuario->id]);
    }

    public function test_gerente_solo_puede_editar_clientes_sin_cambiar_su_rol(): void
    {
        $gerente = Usuario::factory()->gerente()->create();
        $cliente = Usuario::factory()->cliente()->create();
        $otroGerente = Usuario::factory()->gerente()->create();

        $this->actingAs($gerente)->put(route('usuarios.update', $cliente), [
            'nombre' => $cliente->nombre,
            'apellidos' => 'Hernandez Lopez',
            'correo' => $cliente->correo,
            'clave' => '',
            'clave_confirmation' => '',
            'rol' => UserRole::Client->value,
        ])->assertRedirect(route('usuarios.show', $cliente));

        $this->assertDatabaseHas('usuarios', [
            'id' => $cliente->id,
            'apellidos' => 'Hernandez Lopez',
            'rol' => UserRole::Client->value,
        ]);

        $this->actingAs($gerente)->put(route('usuarios.update', $cliente), [
            'nombre' => $cliente->nombre,
            'apellidos' => $cliente->apellidos,
            'correo' => $cliente->correo,
            'rol' => UserRole::Administrator->value,
        ])->assertSessionHasErrors('rol');

        $this->actingAs($gerente)
            ->get(route('usuarios.edit', $otroGerente))
            ->assertForbidden();
    }
}
