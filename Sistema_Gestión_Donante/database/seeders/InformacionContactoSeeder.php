<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InformacionContacto;

class InformacionContactoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $informacionContactos = [
            // Contactos para María González (donante_id: 1)
            [
                'donante_id' => 1,
                'nombre_contacto' => 'Pedro González',
                'telefono' => '555-0201',
                'relacion' => 'Hermano',
            ],
            [
                'donante_id' => 1,
                'nombre_contacto' => 'Ana González',
                'telefono' => '555-0202',
                'relacion' => 'Madre',
            ],
            
            // Contactos para Carlos Rodríguez (donante_id: 2)
            [
                'donante_id' => 2,
                'nombre_contacto' => 'Laura Rodríguez',
                'telefono' => '555-0203',
                'relacion' => 'Esposa',
            ],
            [
                'donante_id' => 2,
                'nombre_contacto' => 'Miguel Rodríguez',
                'telefono' => '555-0204',
                'relacion' => 'Padre',
            ],
            
            // Contactos para Ana Martínez (donante_id: 3)
            [
                'donante_id' => 3,
                'nombre_contacto' => 'José Martínez',
                'telefono' => '555-0205',
                'relacion' => 'Esposo',
            ],
            [
                'donante_id' => 3,
                'nombre_contacto' => 'Carmen Vega',
                'telefono' => '555-0206',
                'relacion' => 'Amiga',
            ],
            
            // Contactos para Luis Fernández (donante_id: 4)
            [
                'donante_id' => 4,
                'nombre_contacto' => 'Rosa Fernández',
                'telefono' => '555-0207',
                'relacion' => 'Hermana',
            ],
            [
                'donante_id' => 4,
                'nombre_contacto' => 'Antonio López',
                'telefono' => '555-0208',
                'relacion' => 'Cuñado',
            ],
            
            // Contactos para Carmen López (donante_id: 5)
            [
                'donante_id' => 5,
                'nombre_contacto' => 'Roberto López',
                'telefono' => '555-0209',
                'relacion' => 'Hijo',
            ],
            [
                'donante_id' => 5,
                'nombre_contacto' => 'Elena Morales',
                'telefono' => '555-0210',
                'relacion' => 'Vecina',
            ],
        ];

        foreach ($informacionContactos as $informacionContacto) {
            InformacionContacto::create($informacionContacto);
        }
    }
}
