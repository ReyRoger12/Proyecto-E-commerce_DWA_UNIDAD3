<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Venta;
use BackedEnum;

class VentaPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return in_array($this->rol($usuario), [
            'administrador',
            'gerente',
            'cliente',
        ], true);
    }

    public function view(Usuario $usuario, Venta $venta): bool
    {
        return $this->esResponsable($usuario)
            || $venta->cliente_id === $usuario->id
            || $venta->vendedor_id === $usuario->id;
    }

    public function create(Usuario $usuario): bool
    {
        return $this->viewAny($usuario);
    }

    public function createFor(Usuario $usuario, int $clienteId): bool
    {
        return $this->esResponsable($usuario)
            || ($this->rol($usuario) === 'cliente' && $usuario->id === $clienteId);
    }

    public function update(Usuario $usuario, Venta $venta): bool
    {
        return $this->esResponsable($usuario);
    }

    public function delete(Usuario $usuario, Venta $venta): bool
    {
        return $this->esResponsable($usuario);
    }

    private function esResponsable(Usuario $usuario): bool
    {
        return in_array($this->rol($usuario), ['administrador', 'gerente'], true);
    }

    private function rol(Usuario $usuario): string
    {
        return $usuario->rol instanceof BackedEnum
            ? $usuario->rol->value
            : (string) $usuario->rol;
    }
}
