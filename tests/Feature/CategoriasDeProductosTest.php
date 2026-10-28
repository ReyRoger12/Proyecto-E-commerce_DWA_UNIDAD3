<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriasDeProductosTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_obtiene_categorias_mediante_sus_productos(): void
    {
        $vendedor = Usuario::factory()->gerente()->create();
        $producto = Producto::create([
            'nombre' => 'Laptop',
            'descripcion' => 'Equipo portátil',
            'precio' => 15999,
            'existencia' => 10,
            'usuario_id' => $vendedor->id,
        ]);
        $categoria = Categoria::create([
            'nombre' => 'Tecnología',
            'descripcion' => 'Equipos electrónicos',
        ]);

        $producto->categorias()->attach($categoria);

        $this->assertTrue(
            $vendedor->asignacionesCategoria()->where('categoria_id', $categoria->id)->exists(),
        );
        $this->assertSame(
            ['Tecnología'],
            $vendedor->categoriasDeProductos()->pluck('nombre')->all(),
        );
    }
}
