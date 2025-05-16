<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HistorialColaboracion;
use Carbon\Carbon;

class HistorialColaboracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $historialColaboraciones = [
            [
                'donante_id' => 1,
                'tipo_colaboracion' => 'Económica',
                'descripcion' => 'Donación de $100 para alimento de mascotas',
                'fecha_colaboracion' => Carbon::now()->subDays(25),
            ],
            [
                'donante_id' => 1,
                'tipo_colaboracion' => 'Mascota',
                'descripcion' => 'Donación de perro mestizo de 2 años',
                'fecha_colaboracion' => Carbon::now()->subDays(20),
            ],
            [
                'donante_id' => 2,
                'tipo_colaboracion' => 'Voluntariado',
                'descripcion' => 'Participación en jornada de limpieza del refugio',
                'fecha_colaboracion' => Carbon::now()->subDays(18),
            ],
            [
                'donante_id' => 2,
                'tipo_colaboracion' => 'Mascota',
                'descripcion' => 'Donación de gato persa de 1 año',
                'fecha_colaboracion' => Carbon::now()->subDays(15),
            ],
            [
                'donante_id' => 3,
                'tipo_colaboracion' => 'Económica',
                'descripcion' => 'Donación de $50 para medicamentos veterinarios',
                'fecha_colaboracion' => Carbon::now()->subDays(12),
            ],
            [
                'donante_id' => 3,
                'tipo_colaboracion' => 'Mascota',
                'descripcion' => 'Donación de conejo holandés',
                'fecha_colaboracion' => Carbon::now()->subDays(10),
            ],
            [
                'donante_id' => 4,
                'tipo_colaboracion' => 'Material',
                'descripcion' => 'Donación de juguetes y accesorios para mascotas',
                'fecha_colaboracion' => Carbon::now()->subDays(8),
            ],
            [
                'donante_id' => 5,
                'tipo_colaboracion' => 'Económica',
                'descripcion' => 'Donación de $75 para gastos operativos',
                'fecha_colaboracion' => Carbon::now()->subDays(6),
            ],
            [
                'donante_id' => 5,
                'tipo_colaboracion' => 'Mascota',
                'descripcion' => 'Donación de hamster con jaula y accesorios',
                'fecha_colaboracion' => Carbon::now()->subDays(5),
            ],
            [
                'donante_id' => 1,
                'tipo_colaboracion' => 'Voluntariado',
                'descripcion' => 'Ayuda en campaña de adopción del fin de semana',
                'fecha_colaboracion' => Carbon::now()->subDays(3),
            ],
        ];

        foreach ($historialColaboraciones as $historialColaboracion) {
            HistorialColaboracion::create($historialColaboracion);
        }
    }
}
