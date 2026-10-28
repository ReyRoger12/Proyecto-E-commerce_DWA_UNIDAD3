<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class CatalogoTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_administrador_puede_gestionar_productos_y_sus_categorias(): void
    {
        $administrador = Usuario::factory()->administrador()->create();
        $vendedor = Usuario::factory()->gerente()->create();
        $tecnologia = Categoria::create([
            'nombre' => 'Tecnología',
            'descripcion' => 'Equipos electrónicos.',
        ]);
        $hogar = Categoria::create([
            'nombre' => 'Hogar',
            'descripcion' => 'Artículos para el hogar.',
        ]);

        $this->actingAs($administrador)->post(route('productos.store'), [
            'nombre' => 'Bocina',
            'descripcion' => 'Bocina inalámbrica.',
            'precio' => 899.50,
            'existencia' => 12,
            'usuario_id' => $vendedor->id,
            'categorias' => [$tecnologia->id, $hogar->id],
        ])->assertRedirect(route('productos.index'));

        $producto = Producto::query()->firstOrFail();

        $this->assertSame($vendedor->id, $producto->vendedor->id);
        $this->assertCount(2, $producto->categorias);
        $this->assertDatabaseHas('categoria_producto', [
            'producto_id' => $producto->id,
            'categoria_id' => $tecnologia->id,
        ]);

        $this->actingAs($administrador)->put(route('productos.update', $producto), [
            'nombre' => 'Bocina portátil',
            'descripcion' => 'Bocina inalámbrica actualizada.',
            'precio' => 999.00,
            'existencia' => 8,
            'usuario_id' => $vendedor->id,
            'categorias' => [$tecnologia->id],
        ])->assertRedirect(route('productos.index'));

        $this->assertDatabaseHas('productos', [
            'id' => $producto->id,
            'nombre' => 'Bocina portátil',
            'existencia' => 8,
        ]);
        $this->assertDatabaseMissing('categoria_producto', [
            'producto_id' => $producto->id,
            'categoria_id' => $hogar->id,
        ]);

        $this->actingAs($administrador)
            ->delete(route('productos.destroy', $producto))
            ->assertRedirect(route('productos.index'));

        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    public function test_cliente_puede_consultar_productos_pero_no_administrarlos(): void
    {
        $cliente = Usuario::factory()->cliente()->create();

        $this->actingAs($cliente)
            ->get(route('productos.index'))
            ->assertOk();

        $this->actingAs($cliente)
            ->get(route('productos.create'))
            ->assertForbidden();
    }

    public function test_administrador_puede_gestionar_categorias(): void
    {
        $administrador = Usuario::factory()->administrador()->create();

        $this->actingAs($administrador)->post(route('categorias.store'), [
            'nombre' => 'Tecnología',
            'descripcion' => 'Equipos y accesorios.',
        ])->assertRedirect(route('categorias.index'));

        $categoria = Categoria::query()->firstOrFail();

        $this->actingAs($administrador)->put(route('categorias.update', $categoria), [
            'nombre' => 'Tecnología y cómputo',
            'descripcion' => 'Equipos, accesorios y computadoras.',
        ])->assertRedirect(route('categorias.index'));

        $this->assertDatabaseHas('categorias', [
            'id' => $categoria->id,
            'nombre' => 'Tecnología y cómputo',
        ]);

        $this->actingAs($administrador)
            ->delete(route('categorias.destroy', $categoria))
            ->assertRedirect(route('categorias.index'));

        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
    }

    public function test_form_requests_rechazan_datos_incompletos(): void
    {
        $administrador = Usuario::factory()->administrador()->create();

        $this->actingAs($administrador)
            ->post(route('productos.store'), [])
            ->assertSessionHasErrors([
                'nombre',
                'descripcion',
                'precio',
                'existencia',
                'usuario_id',
                'categorias',
            ]);

        $this->assertDatabaseCount('productos', 0);
    }
}
