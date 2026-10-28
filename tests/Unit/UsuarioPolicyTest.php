<?php

namespace Tests\Unit;

use App\Enums\UserRole;
use App\Models\Usuario;
use App\Policies\UsuarioPolicy;
use PHPUnit\Framework\TestCase;

class UsuarioPolicyTest extends TestCase
{
    public function test_administrador_puede_administrar_usuarios(): void
    {
        $administrador = $this->usuario(1, UserRole::Administrator);
        $objetivo = $this->usuario(2, UserRole::Manager);
        $policy = new UsuarioPolicy;

        $this->assertTrue($policy->create($administrador));
        $this->assertTrue($policy->update($administrador, $objetivo));
        $this->assertTrue($policy->delete($administrador, $objetivo));
    }

    public function test_gerente_solo_puede_editar_clientes(): void
    {
        $gerente = $this->usuario(1, UserRole::Manager);
        $cliente = $this->usuario(2, UserRole::Client);
        $otroGerente = $this->usuario(3, UserRole::Manager);
        $administrador = $this->usuario(4, UserRole::Administrator);
        $policy = new UsuarioPolicy;

        $this->assertTrue($policy->update($gerente, $cliente));
        $this->assertFalse($policy->update($gerente, $otroGerente));
        $this->assertFalse($policy->update($gerente, $administrador));
        $this->assertFalse($policy->delete($gerente, $cliente));
    }

    private function usuario(int $id, UserRole $rol): Usuario
    {
        $usuario = new Usuario(['rol' => $rol]);
        $usuario->id = $id;

        return $usuario;
    }
}
