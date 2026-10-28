<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\Usuario;
use BackedEnum;

class ProductoPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return true;
    }

    public function view(Usuario $usuario, Producto $producto): bool
    {
        return true;
    }

    public function create(Usuario $usuario): bool
    {
        return $this->puedeAdministrar($usuario);
    }

    public function update(Usuario $usuario, Producto $producto): bool
    {
        return $this->puedeAdministrar($usuario);
    }

    public function delete(Usuario $usuario, Producto $producto): bool
    {
        return $this->puedeAdministrar($usuario);
    }

    private function puedeAdministrar(Usuario $usuario): bool
    {
        $rol = $usuario->rol instanceof BackedEnum
            ? $usuario->rol->value
            : (string) $usuario->rol;

        return in_array($rol, ['administrador', 'gerente'], true);
    }
}
