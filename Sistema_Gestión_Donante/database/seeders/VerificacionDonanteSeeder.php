<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VerificacionDonante;
use Carbon\Carbon;

class VerificacionDonanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $verificacionesDonantes = [
            [
                'donante_id' => 1,
                'fecha_verificacion' => Carbon::now()->subDays(28),
                'resultado' => 'Aprobado',
                'observaciones' => 'Documentos en orden, domicilio verificado, referencias positivas.',
            ],
            [
                'donante_id' => 2,
                'fecha_verificacion' => Carbon::now()->subDays(23),
                'resultado' => 'Aprobado',
                'observaciones' => 'Verificación exitosa, historial limpio, buenas referencias.',
            ],
            [
                'donante_id' => 3,
                'fecha_verificacion' => Carbon::now()->subDays(18),
                'resultado' => 'Observación',
                'observaciones' => 'Documentos correctos, pero se requiere verificación adicional de ingresos.',
            ],
            [
                'donante_id' => 3,
                'fecha_verificacion' => Carbon::now()->subDays(16),
                'resultado' => 'Aprobado',
                'observaciones' => 'Verificación adicional completada satisfactoriamente.',
            ],
            [
                'donante_id' => 4,
                'fecha_verificacion' => Carbon::now()->subDays(13),
                'resultado' => 'Rechazado',
                'observaciones' => 'Documentos incompletos, dirección no verificable.',
            ],
            [
                'donante_id' => 4,
                'fecha_verificacion' => Carbon::now()->subDays(10),
                'resultado' => 'Observación',
                'observaciones' => 'Documentos actualizados, pendiente verificación de domicilio.',
            ],
            [
                'donante_id' => 5,
                'fecha_verificacion' => Carbon::now()->subDays(8),
                'resultado' => 'Aprobado',
                'observaciones' => 'Verificación completa y exitosa, donante confiable.',
            ],
            [
                'donante_id' => 1,
                'fecha_verificacion' => Carbon::now()->subDays(5),
                'resultado' => 'Aprobado',
                'observaciones' => 'Reverificación anual completada exitosamente.',
            ],
            [
                'donante_id' => 2,
                'fecha_verificacion' => Carbon::now()->subDays(3),
                'resultado' => 'Aprobado',
                'observaciones' => 'Actualización de datos verificada correctamente.',
            ],
            [
                'donante_id' => 5,
                'fecha_verificacion' => Carbon::now()->subDays(1),
                'resultado' => 'Aprobado',
                'observaciones' => 'Verificación de nueva dirección completada.',
            ],
        ];

        foreach ($verificacionesDonantes as $verificacionDonante) {
            VerificacionDonante::create($verificacionDonante);
        }
    }
}
