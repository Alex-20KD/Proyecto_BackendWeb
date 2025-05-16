<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\InformacionContacto;
use App\Models\Donante;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InformacionContactoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que verifica la creación de información de contacto.
     */
    public function test_puede_crear_informacion_contacto(): void
    {
        // Crear un donante primero
        $donante = Donante::factory()->create();

        $informacionContactoData = [
            'donante_id' => $donante->id,
            'nombre_contacto' => 'Pedro García',
            'telefono' => '555-0201',
            'relacion' => 'Hermano',
        ];

        $informacionContacto = InformacionContacto::create($informacionContactoData);

        $this->assertInstanceOf(InformacionContacto::class, $informacionContacto);
        $this->assertEquals($donante->id, $informacionContacto->donante_id);
        $this->assertEquals('Pedro García', $informacionContacto->nombre_contacto);
        $this->assertEquals('555-0201', $informacionContacto->telefono);
        $this->assertEquals('Hermano', $informacionContacto->relacion);
    }

    /**
     * Test que verifica las relaciones de información de contacto.
     */
    public function test_informacion_contacto_tiene_relaciones(): void
    {
        $informacionContacto = new InformacionContacto();

        $this->assertTrue(method_exists($informacionContacto, 'donante'));
    }

    /**
     * Test que verifica los campos fillable.
     */
    public function test_informacion_contacto_campos_fillable(): void
    {
        $informacionContacto = new InformacionContacto();
        $fillable = $informacionContacto->getFillable();

        $expectedFillable = [
            'donante_id',
            'nombre_contacto',
            'telefono',
            'relacion'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /**
     * Test que verifica la relación con donante.
     */
    public function test_informacion_contacto_pertenece_a_donante(): void
    {
        $donante = Donante::factory()->create();
        $informacionContacto = InformacionContacto::factory()->create(['donante_id' => $donante->id]);

        $this->assertInstanceOf(Donante::class, $informacionContacto->donante);
        $this->assertEquals($donante->id, $informacionContacto->donante->id);
    }

    /**
     * Test que verifica las relaciones familiares válidas.
     */
    public function test_relaciones_validas(): void
    {
        $relacionesValidas = ['Hermano', 'Hermana', 'Padre', 'Madre', 'Esposo', 'Esposa', 'Hijo', 'Hija', 'Amigo', 'Vecino'];
        
        foreach ($relacionesValidas as $relacion) {
            $donante = Donante::factory()->create();
            $informacionContacto = InformacionContacto::create([
                'donante_id' => $donante->id,
                'nombre_contacto' => 'Contacto de Prueba',
                'telefono' => '555-0000',
                'relacion' => $relacion,
            ]);

            $this->assertEquals($relacion, $informacionContacto->relacion);
        }
    }

    /**
     * Test que verifica que el nombre de contacto no puede estar vacío.
     */
    public function test_nombre_contacto_no_puede_estar_vacio(): void
    {
        $donante = Donante::factory()->create();
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        InformacionContacto::create([
            'donante_id' => $donante->id,
            'nombre_contacto' => '',
            'telefono' => '555-0000',
            'relacion' => 'Hermano',
        ]);
    }

    /**
     * Test que verifica que el teléfono no puede estar vacío.
     */
    public function test_telefono_no_puede_estar_vacio(): void
    {
        $donante = Donante::factory()->create();
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        InformacionContacto::create([
            'donante_id' => $donante->id,
            'nombre_contacto' => 'Pedro García',
            'telefono' => '',
            'relacion' => 'Hermano',
        ]);
    }

    /**
     * Test que verifica múltiples contactos para un donante.
     */
    public function test_donante_puede_tener_multiples_contactos(): void
    {
        $donante = Donante::factory()->create();
        
        $contacto1 = InformacionContacto::create([
            'donante_id' => $donante->id,
            'nombre_contacto' => 'Pedro García',
            'telefono' => '555-0001',
            'relacion' => 'Hermano',
        ]);

        $contacto2 = InformacionContacto::create([
            'donante_id' => $donante->id,
            'nombre_contacto' => 'Ana García',
            'telefono' => '555-0002',
            'relacion' => 'Madre',
        ]);

        $this->assertEquals($donante->id, $contacto1->donante_id);
        $this->assertEquals($donante->id, $contacto2->donante_id);
        $this->assertNotEquals($contacto1->id, $contacto2->id);
    }
}
