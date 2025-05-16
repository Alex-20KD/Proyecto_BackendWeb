<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InformacionContacto;
use App\Models\Donante;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InformacionContacto>
 */
class InformacionContactoFactory extends Factory
{
    protected $model = InformacionContacto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donante_id' => Donante::factory(),
            'nombre_contacto' => $this->faker->name(),
            'telefono' => $this->faker->phoneNumber(),
            'relacion' => $this->faker->randomElement([
                'Hermano', 'Hermana', 'Padre', 'Madre', 'Esposo', 'Esposa', 
                'Hijo', 'Hija', 'Amigo', 'Amiga', 'Vecino', 'Vecina', 'Colega'
            ]),
        ];
    }

    /**
     * Estado para contactos familiares.
     */
    public function familiar()
    {
        return $this->state(function (array $attributes) {
            return [
                'relacion' => $this->faker->randomElement([
                    'Hermano', 'Hermana', 'Padre', 'Madre', 'Esposo', 'Esposa', 'Hijo', 'Hija'
                ]),
            ];
        });
    }

    /**
     * Estado para contactos no familiares.
     */
    public function noFamiliar()
    {
        return $this->state(function (array $attributes) {
            return [
                'relacion' => $this->faker->randomElement([
                    'Amigo', 'Amiga', 'Vecino', 'Vecina', 'Colega', 'Conocido', 'Conocida'
                ]),
            ];
        });
    }
}
