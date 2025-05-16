<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\HistorialColaboracion;
use App\Models\Donante;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HistorialColaboracionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que verifica la creación de un historial de colaboración.
     */
    public function test_puede_crear_historial_colaboracion(): void
    {
        // Crear un donante primero
        $donante = Donante::factory()->create();

        $historialColaboracionData = [
            'donante_id' => $donante->id,
            'tipo_colaboracion' => 'Económica',
            'descripcion' => 'Donación de $100 para alimento de mascotas',
            'fecha_colaboracion' => '2023-06-08',
        ];

        $historialColaboracion = HistorialColaboracion::create($historialColaboracionData);

        $this->assertInstanceOf(HistorialColaboracion::class, $historialColaboracion);
        $this->assertEquals($donante->id, $historialColaboracion->donante_id);
        $this->assertEquals('Económica', $historialColaboracion->tipo_colaboracion);
        $this->assertEquals('Donación de $100 para alimento de mascotas', $historialColaboracion->descripcion);
    }

    /**
     * Test que verifica las relaciones del historial de colaboración.
     */
    public function test_historial_colaboracion_tiene_relaciones(): void
    {
        $historialColaboracion = new HistorialColaboracion();

        $this->assertTrue(method_exists($historialColaboracion, 'donante'));
    }

    /**
     * Test que verifica los campos fillable.
     */
    public function test_historial_colaboracion_campos_fillable(): void
    {
        $historialColaboracion = new HistorialColaboracion();
        $fillable = $historialColaboracion->getFillable();

        $expectedFillable = [
            'donante_id',
            'tipo_colaboracion',
            'descripcion',
            'fecha_colaboracion'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /**
     * Test que verifica la relación con donante.
     */
    public function test_historial_colaboracion_pertenece_a_donante(): void
    {
        $donante = Donante::factory()->create();
        $historialColaboracion = HistorialColaboracion::factory()->create(['donante_id' => $donante->id]);

        $this->assertInstanceOf(Donante::class, $historialColaboracion->donante);
        $this->assertEquals($donante->id, $historialColaboracion->donante->id);
    }

    /**
     * Test que verifica los tipos de colaboración válidos.
     */
    public function test_tipos_colaboracion_validos(): void
    {
        $tiposValidos = ['Mascota', 'Económica', 'Voluntariado', 'Material'];
        
        foreach ($tiposValidos as $tipo) {
            $donante = Donante::factory()->create();
            $historialColaboracion = HistorialColaboracion::create([
                'donante_id' => $donante->id,
                'tipo_colaboracion' => $tipo,
                'descripcion' => 'Descripción de prueba',
                'fecha_colaboracion' => '2023-06-08',
            ]);

            $this->assertEquals($tipo, $historialColaboracion->tipo_colaboracion);
        }
    }

    /**
     * Test que verifica el cast de fecha.
     */
    public function test_fecha_colaboracion_es_cast_a_date(): void
    {
        $donante = Donante::factory()->create();
        $historialColaboracion = HistorialColaboracion::create([
            'donante_id' => $donante->id,
            'tipo_colaboracion' => 'Económica',
            'descripcion' => 'Descripción de prueba',
            'fecha_colaboracion' => '2023-06-08',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $historialColaboracion->fecha_colaboracion);
    }

    /**
     * Test que verifica que la descripción no puede estar vacía.
     */
    public function test_descripcion_no_puede_estar_vacia(): void
    {
        $donante = Donante::factory()->create();
        
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        HistorialColaboracion::create([
            'donante_id' => $donante->id,
            'tipo_colaboracion' => 'Económica',
            'descripcion' => '',
            'fecha_colaboracion' => '2023-06-08',
        ]);
    }
}
