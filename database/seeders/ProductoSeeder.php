<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $vendedor = Usuario::query()
            ->whereIn('rol', ['administrador', 'gerente'])
            ->firstOrFail();

        $productos = [
            [
                'nombre' => 'Laptop',
                'descripcion' => 'Equipo portátil para estudio y trabajo.',
                'precio' => 15999.00,
                'existencia' => 10,
                'categorias' => ['Tecnología'],
            ],
            [
                'nombre' => 'Bocina inalámbrica',
                'descripcion' => 'Bocina compacta con conexión Bluetooth.',
                'precio' => 899.00,
                'existencia' => 25,
                'categorias' => ['Tecnología', 'Hogar'],
            ],
            [
                'nombre' => 'Sudadera',
                'descripcion' => 'Sudadera de algodón para uso diario.',
                'precio' => 649.00,
                'existencia' => 18,
                'categorias' => ['Ropa'],
            ],
        ];

        foreach ($productos as $datos) {
            $categorias = $datos['categorias'];
            unset($datos['categorias']);

            $producto = Producto::query()->updateOrCreate(
                ['nombre' => $datos['nombre']],
                [...$datos, 'usuario_id' => $vendedor->id],
            );

            $producto->categorias()->sync(
                Categoria::query()->whereIn('nombre', $categorias)->pluck('id'),
            );
        }
    }
}
