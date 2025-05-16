<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VerificacionDonante;
use App\Models\Donante;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VerificacionDonante>
 */
class VerificacionDonanteFactory extends Factory
{
    protected $model = VerificacionDonante::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donante_id' => Donante::factory(),
            'fecha_verificacion' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'resultado' => $this->faker->randomElement(['Aprobado', 'Observación', 'Rechazado']),
            'observaciones' => $this->faker->optional(0.8)->paragraph(),
        ];
    }

    /**
     * Estado para verificaciones aprobadas.
     */
    public function aprobado()
    {
        return $this->state(function (array $attributes) {
            return [
                'resultado' => 'Aprobado',
                'observaciones' => $this->faker->randomElement([
                    'Documentos en orden, domicilio verificado, referencias positivas.',
                    'Verificación exitosa, historial limpio, buenas referencias.',
                    'Verificación completa y exitosa, donante confiable.',
                    'Todos los requisitos cumplidos satisfactoriamente.',
                    null
                ]),
            ];
        });
    }

    /**
     * Estado para verificaciones con observaciones.
     */
    public function observacion()
    {
        return $this->state(function (array $attributes) {
            return [
                'resultado' => 'Observación',
                'observaciones' => $this->faker->randomElement([
                    'Documentos correctos, pero se requiere verificación adicional de ingresos.',
                    'Pendiente verificación de domicilio.',
                    'Se requiere actualización de documentos de identidad.',
                    'Verificación parcial, pendiente referencias personales.',
                ]),
            ];
        });
    }

    /**
     * Estado para verificaciones rechazadas.
     */
    public function rechazado()
    {
        return $this->state(function (array $attributes) {
            return [
                'resultado' => 'Rechazado',
                'observaciones' => $this->faker->randomElement([
                    'Documentos incompletos, dirección no verificable.',
                    'Inconsistencias en la información proporcionada.',
                    'Referencias negativas de adopciones anteriores.',
                    'No cumple con los requisitos mínimos establecidos.',
                ]),
            ];
        });
    }
}
