<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MascotaDonada;
use App\Models\Donante;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MascotaDonada>
 */
class MascotaDonadaFactory extends Factory
{
    protected $model = MascotaDonada::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donante_id' => Donante::factory(),
            'mascota_id' => $this->faker->numberBetween(1, 10),
            'fecha_donacion' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'motivo_donacion' => $this->faker->randomElement([
                'Me mudo a un apartamento que no permite mascotas',
                'Problemas de salud en la familia',
                'Viaje de trabajo prolongado',
                'Llegada de un bebé a la familia',
                'Situación económica difícil',
                'Falta de tiempo para cuidar adecuadamente',
                'Alergias desarrolladas recientemente',
                'Incompatibilidad con otras mascotas'
            ]),
            'estado_revision' => $this->faker->randomElement(['Pendiente', 'Aceptada', 'Rechazada']),
        ];
    }
}
