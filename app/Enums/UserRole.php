<?php

namespace App\Enums;

enum UserRole: string
{
    case Client = 'cliente';
    case Employee = 'empleado';
    case Manager = 'gerente';
}
