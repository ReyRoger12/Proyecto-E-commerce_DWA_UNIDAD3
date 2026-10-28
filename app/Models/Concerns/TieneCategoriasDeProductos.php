<?php

namespace App\Models\Concerns;

use App\Models\Categoria;
use App\Models\CategoriaProducto;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait TieneCategoriasDeProductos
{
    public function asignacionesCategoria(): HasManyThrough
    {
        return $this->hasManyThrough(
            CategoriaProducto::class,
            Producto::class,
            'usuario_id',
            'producto_id',
            'id',
            'id',
        );
    }

    public function categoriasDeProductos(): Builder
    {
        return Categoria::query()
            ->whereIn(
                'id',
                $this->asignacionesCategoria()->select('categoria_id'),
            )
            ->distinct();
    }
}
