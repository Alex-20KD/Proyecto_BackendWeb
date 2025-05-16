<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donante;
use Carbon\Carbon;

class DonanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donantes = [
            [
                'nombre' => 'María González',
                'correo' => 'maria.gonzalez@email.com',
                'telefono' => '555-0101',
                'direccion' => 'Av. Principal 123, Ciudad',
                'tipo_documento' => 'DNI',
                'numero_documento' => '12345678',
                'fecha_registro' => Carbon::now()->subDays(30),
                'estado' => 'Activo',
            ],
            [
                'nombre' => 'Carlos Rodríguez',
                'correo' => 'carlos.rodriguez@email.com',
                'telefono' => '555-0102',
                'direccion' => 'Calle Secundaria 456, Ciudad',
                'tipo_documento' => 'DNI',
                'numero_documento' => '87654321',
                'fecha_registro' => Carbon::now()->subDays(25),
                'estado' => 'Activo',
            ],
            [
                'nombre' => 'Ana Martínez',
                'correo' => 'ana.martinez@email.com',
                'telefono' => '555-0103',
                'direccion' => 'Plaza Central 789, Ciudad',
                'tipo_documento' => 'Pasaporte',
                'numero_documento' => 'AB123456',
                'fecha_registro' => Carbon::now()->subDays(20),
                'estado' => 'Activo',
            ],
            [
                'nombre' => 'Luis Fernández',
                'correo' => 'luis.fernandez@email.com',
                'telefono' => '555-0104',
                'direccion' => 'Barrio Norte 321, Ciudad',
                'tipo_documento' => 'DNI',
                'numero_documento' => '11223344',
                'fecha_registro' => Carbon::now()->subDays(15),
                'estado' => 'Inactivo',
            ],
            [
                'nombre' => 'Carmen López',
                'correo' => 'carmen.lopez@email.com',
                'telefono' => '555-0105',
                'direccion' => 'Zona Sur 654, Ciudad',
                'tipo_documento' => 'DNI',
                'numero_documento' => '55667788',
                'fecha_registro' => Carbon::now()->subDays(10),
                'estado' => 'Activo',
            ],
        ];

        foreach ($donantes as $donante) {
            Donante::create($donante);
        }
    }
}
