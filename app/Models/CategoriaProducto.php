<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoriaProducto extends Pivot
{
    protected $table = 'categoria_producto';

    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'categoria_id',
    ];
}
