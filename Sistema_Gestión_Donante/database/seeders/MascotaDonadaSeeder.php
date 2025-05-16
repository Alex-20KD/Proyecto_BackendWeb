<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MascotaDonada;
use Carbon\Carbon;

class MascotaDonadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mascotasDonadas = [
            [
                'donante_id' => 1,
                'mascota_id' => 1, // Asumiendo que existe una mascota con ID 1
                'fecha_donacion' => Carbon::now()->subDays(20),
                'motivo_donacion' => 'Me mudo a un apartamento que no permite mascotas',
                'estado_revision' => 'Aceptada',
            ],
            [
                'donante_id' => 2,
                'mascota_id' => 2,
                'fecha_donacion' => Carbon::now()->subDays(15),
                'motivo_donacion' => 'Problemas de salud en la familia',
                'estado_revision' => 'Pendiente',
            ],
            [
                'donante_id' => 3,
                'mascota_id' => 3,
                'fecha_donacion' => Carbon::now()->subDays(10),
                'motivo_donacion' => 'Viaje de trabajo prolongado',
                'estado_revision' => 'Aceptada',
            ],
            [
                'donante_id' => 1,
                'mascota_id' => 4,
                'fecha_donacion' => Carbon::now()->subDays(8),
                'motivo_donacion' => 'Llegada de un bebé a la familia',
                'estado_revision' => 'Rechazada',
            ],
            [
                'donante_id' => 5,
                'mascota_id' => 5,
                'fecha_donacion' => Carbon::now()->subDays(5),
                'motivo_donacion' => 'Situación económica difícil',
                'estado_revision' => 'Pendiente',
            ],
        ];

        foreach ($mascotasDonadas as $mascotaDonada) {
            MascotaDonada::create($mascotaDonada);
        }
    }
}
