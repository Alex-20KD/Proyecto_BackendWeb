<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HistorialColaboracion;
use App\Models\Donante;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistorialColaboracion>
 */
class HistorialColaboracionFactory extends Factory
{
    protected $model = HistorialColaboracion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donante_id' => Donante::factory(),
            'tipo_colaboracion' => $this->faker->randomElement(['Económica', 'Mascota', 'Voluntariado', 'Material']),
            'descripcion' => $this->faker->sentence(10),
            'fecha_colaboracion' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Estado para colaboraciones económicas.
     */
    public function economica()
    {
        return $this->state(function (array $attributes) {
            return [
                'tipo_colaboracion' => 'Económica',
                'descripcion' => 'Donación de $' . $this->faker->numberBetween(50, 500) . ' para ' . 
                    $this->faker->randomElement(['alimento', 'medicamentos', 'gastos veterinarios', 'infraestructura']),
            ];
        });
    }

    /**
     * Estado para colaboraciones de mascota.
     */
    public function mascota()
    {
        return $this->state(function (array $attributes) {
            return [
                'tipo_colaboracion' => 'Mascota',
                'descripcion' => 'Donación de ' . 
                    $this->faker->randomElement(['perro', 'gato', 'conejo', 'hamster', 'ave']) . ' ' .
                    $this->faker->randomElement(['mestizo', 'de raza', 'cachorro', 'adulto']),
            ];
        });
    }

    /**
     * Estado para colaboraciones de voluntariado.
     */
    public function voluntariado()
    {
        return $this->state(function (array $attributes) {
            return [
                'tipo_colaboracion' => 'Voluntariado',
                'descripcion' => 'Participación en ' . 
                    $this->faker->randomElement([
                        'jornada de limpieza', 
                        'campaña de adopción', 
                        'paseo de mascotas',
                        'cuidado de animales',
                        'evento benéfico'
                    ]),
            ];
        });
    }
}
