<?php

namespace App\Enums;

enum UserRole: string
{
    case Administrator = 'administrador';
    case Manager = 'gerente';
    case Client = 'cliente';

    public function dashboardRoute(): string
    {
        return match ($this) {
            self::Administrator => 'administrador.dashboard',
            self::Manager => 'gerente.dashboard',
            self::Client => 'cliente.dashboard',
        };
    }
}
