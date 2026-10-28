<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Models\Concerns\TieneCategoriasDeProductos;
use Database\Factories\UsuarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    /** @use HasFactory<UsuarioFactory> */
    use HasFactory, Notifiable, TieneCategoriasDeProductos;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'clave',
        'rol',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'clave' => 'hashed',
            'rol' => UserRole::class,
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->clave;
    }

    public function getAuthPasswordName(): string
    {
        return 'clave';
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'usuario_id');
    }

    public function ventasComoCliente(): HasMany
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    public function ventasComoVendedor(): HasMany
    {
        return $this->hasMany(Venta::class, 'vendedor_id');
    }
}
