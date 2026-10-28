<?php

namespace Tests\Feature;

use App\Events\VentaCreada;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class VentaCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrador_puede_crear_actualizar_y_eliminar_una_venta(): void
    {
        Event::fake([VentaCreada::class]);

        [$administrador, $vendedor, $cliente, $producto] = $this->datosBase();

        $respuesta = $this->actingAs($administrador)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'vendedor_id' => $vendedor->id,
            'cliente_id' => $cliente->id,
            'fecha' => '2026-10-27',
            'total' => '15999.00',
        ]);

        $venta = Venta::firstOrFail();

        $respuesta->assertRedirect(route('ventas.show', $venta));
        $this->assertDatabaseHas('ventas', [
            'id' => $venta->id,
            'producto_id' => $producto->id,
            'vendedor_id' => $vendedor->id,
            'cliente_id' => $cliente->id,
        ]);
        Event::assertDispatched(VentaCreada::class);

        $this->actingAs($administrador)->put(route('ventas.update', $venta), [
            'producto_id' => $producto->id,
            'vendedor_id' => $vendedor->id,
            'cliente_id' => $cliente->id,
            'fecha' => '2026-10-28',
            'total' => '14999.00',
        ])->assertRedirect(route('ventas.show', $venta));

        $this->assertDatabaseHas('ventas', [
            'id' => $venta->id,
            'fecha' => '2026-10-28',
            'total' => 14999,
        ]);

        $this->actingAs($administrador)
            ->delete(route('ventas.destroy', $venta))
            ->assertRedirect(route('ventas.index'));

        $this->assertDatabaseMissing('ventas', ['id' => $venta->id]);
    }

    public function test_cliente_solo_puede_registrar_una_compra_a_su_nombre(): void
    {
        [, $vendedor, $cliente, $producto] = $this->datosBase();
        $otroCliente = Usuario::factory()->cliente()->create();

        $this->actingAs($cliente)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'vendedor_id' => $vendedor->id,
            'cliente_id' => $otroCliente->id,
            'fecha' => '2026-10-27',
            'total' => '15999.00',
        ])->assertForbidden();

        $this->actingAs($cliente)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'vendedor_id' => $vendedor->id,
            'cliente_id' => $cliente->id,
            'fecha' => '2026-10-27',
            'total' => '15999.00',
        ])->assertRedirect();

        $this->assertDatabaseCount('ventas', 1);
    }

    public function test_valida_que_el_vendedor_corresponda_al_producto(): void
    {
        [$administrador, , $cliente, $producto] = $this->datosBase();
        $vendedorIncorrecto = Usuario::factory()->gerente()->create();

        $this->actingAs($administrador)->post(route('ventas.store'), [
            'producto_id' => $producto->id,
            'vendedor_id' => $vendedorIncorrecto->id,
            'cliente_id' => $cliente->id,
            'fecha' => '2026-10-27',
            'total' => '15999.00',
        ])->assertSessionHasErrors('vendedor_id');

        $this->assertDatabaseCount('ventas', 0);
    }

    private function datosBase(): array
    {
        $administrador = Usuario::factory()->administrador()->create();
        $vendedor = Usuario::factory()->gerente()->create();
        $cliente = Usuario::factory()->cliente()->create();
        $producto = Producto::create([
            'nombre' => 'Laptop',
            'descripcion' => 'Equipo portátil',
            'precio' => 15999,
            'existencia' => 10,
            'usuario_id' => $vendedor->id,
        ]);

        return [$administrador, $vendedor, $cliente, $producto];
    }
}
