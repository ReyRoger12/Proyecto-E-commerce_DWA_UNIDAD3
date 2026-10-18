<?php

namespace App\Enums;

enum UserRole: string
{
    case Client = 'cliente';
    case Employee = 'empleado';
    case Manager = 'gerente';

    public function dashboardRoute(): string
    {
        return match ($this) {
            self::Client => 'cliente.dashboard',
            self::Employee => 'empleado.dashboard',
            self::Manager => 'gerente.dashboard',
        };
    }
}
