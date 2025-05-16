<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Donante;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donante>
 */
class DonanteFactory extends Factory
{
    protected $model = Donante::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'correo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'tipo_documento' => $this->faker->randomElement(['DNI', 'Pasaporte', 'Cédula']),
            'numero_documento' => $this->faker->unique()->numerify('########'),
            'fecha_registro' => $this->faker->date(),
            'estado' => $this->faker->randomElement(['Activo', 'Inactivo', 'Suspendido']),
        ];
    }
}
