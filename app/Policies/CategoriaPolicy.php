<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\Usuario;
use BackedEnum;

class CategoriaPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return true;
    }

    public function view(Usuario $usuario, Categoria $categoria): bool
    {
        return true;
    }

    public function create(Usuario $usuario): bool
    {
        return $this->puedeAdministrar($usuario);
    }

    public function update(Usuario $usuario, Categoria $categoria): bool
    {
        return $this->puedeAdministrar($usuario);
    }

    public function delete(Usuario $usuario, Categoria $categoria): bool
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
