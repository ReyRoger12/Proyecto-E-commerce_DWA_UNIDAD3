<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        $nombres = ['Juan', 'Mario', 'Maria', 'Pedro'];
        $apellidos = ['Lopez', 'Sanchez', 'Hernandez', 'Martinez'];
        $combinaciones = [];

        foreach ($nombres as $nombreDisponible) {
            foreach ($apellidos as $apellidoDisponible) {
                $combinaciones[] = [
                    'nombre' => $nombreDisponible,
                    'apellidos' => $apellidoDisponible,
                    'correo' => strtolower(Str::ascii(substr($nombreDisponible, 0, 1).$apellidoDisponible)).'@tuxtla.tecnm.mx',
                ];
            }
        }

        $correosUsados = Usuario::query()->pluck('correo')->all();
        $opciones = collect($combinaciones)
            ->shuffle()
            ->unique('correo')
            ->reject(fn (array $datos): bool => in_array($datos['correo'], $correosUsados, true))
            ->values();

        if ($opciones->isEmpty()) {
            throw new \RuntimeException('No quedan correos institucionales disponibles para la fábrica.');
        }

        $identidad = fake()->randomElement($opciones->all());

        return [
            'nombre' => $identidad['nombre'],
            'apellidos' => $identidad['apellidos'],
            'correo' => $identidad['correo'],
            'clave' => Hash::make('123'),
            'rol' => fake()->randomElement([UserRole::Client, UserRole::Manager]),
            'remember_token' => Str::random(10),
        ];
    }

    public function administrador(): static
    {
        return $this->state(fn () => ['rol' => UserRole::Administrator]);
    }

    public function gerente(): static
    {
        return $this->state(fn () => ['rol' => UserRole::Manager]);
    }

    public function cliente(): static
    {
        return $this->state(fn () => ['rol' => UserRole::Client]);
    }
}
