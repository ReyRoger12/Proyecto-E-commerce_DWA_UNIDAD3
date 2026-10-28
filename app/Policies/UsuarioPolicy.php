<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Usuario;

class UsuarioPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return in_array($usuario->rol, [UserRole::Administrator, UserRole::Manager], true);
    }

    public function view(Usuario $usuario, Usuario $objetivo): bool
    {
        return $usuario->id === $objetivo->id
            || $usuario->rol === UserRole::Administrator
            || ($usuario->rol === UserRole::Manager && $objetivo->rol === UserRole::Client);
    }

    public function create(Usuario $usuario): bool
    {
        return $usuario->rol === UserRole::Administrator;
    }

    public function update(Usuario $usuario, Usuario $objetivo): bool
    {
        return $usuario->rol === UserRole::Administrator
            || ($usuario->rol === UserRole::Manager && $objetivo->rol === UserRole::Client);
    }

    public function delete(Usuario $usuario, Usuario $objetivo): bool
    {
        return $usuario->rol === UserRole::Administrator && $usuario->id !== $objetivo->id;
    }
}
