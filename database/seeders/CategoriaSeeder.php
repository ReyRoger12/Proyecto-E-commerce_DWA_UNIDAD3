<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Tecnología' => 'Equipos electrónicos y accesorios.',
            'Hogar' => 'Artículos útiles para el hogar.',
            'Ropa' => 'Prendas y accesorios personales.',
        ];

        foreach ($categorias as $nombre => $descripcion) {
            Categoria::query()->updateOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => $descripcion],
            );
        }
    }
}
