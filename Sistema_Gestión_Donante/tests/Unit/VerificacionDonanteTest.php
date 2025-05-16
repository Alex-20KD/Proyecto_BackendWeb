<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\VerificacionDonante;
use App\Models\Donante;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerificacionDonanteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que verifica la creación de una verificación de donante.
     */
    public function test_puede_crear_verificacion_donante(): void
    {
        // Crear un donante primero
        $donante = Donante::factory()->create();

        $verificacionDonanteData = [
            'donante_id' => $donante->id,
            'fecha_verificacion' => '2023-06-08',
            'resultado' => 'Aprobado',
            'observaciones' => 'Documentos en orden, domicilio verificado',
        ];

        $verificacionDonante = VerificacionDonante::create($verificacionDonanteData);

        $this->assertInstanceOf(VerificacionDonante::class, $verificacionDonante);
        $this->assertEquals($donante->id, $verificacionDonante->donante_id);
        $this->assertEquals('Aprobado', $verificacionDonante->resultado);
        $this->assertEquals('Documentos en orden, domicilio verificado', $verificacionDonante->observaciones);
    }

    /**
     * Test que verifica las relaciones de verificación de donante.
     */
    public function test_verificacion_donante_tiene_relaciones(): void
    {
        $verificacionDonante = new VerificacionDonante();

        $this->assertTrue(method_exists($verificacionDonante, 'donante'));
    }

    /**
     * Test que verifica los campos fillable.
     */
    public function test_verificacion_donante_campos_fillable(): void
    {
        $verificacionDonante = new VerificacionDonante();
        $fillable = $verificacionDonante->getFillable();

        $expectedFillable = [
            'donante_id',
            'fecha_verificacion',
            'resultado',
            'observaciones'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /**
     * Test que verifica la relación con donante.
     */
    public function test_verificacion_donante_pertenece_a_donante(): void
    {
        $donante = Donante::factory()->create();
        $verificacionDonante = VerificacionDonante::factory()->create(['donante_id' => $donante->id]);

        $this->assertInstanceOf(Donante::class, $verificacionDonante->donante);
        $this->assertEquals($donante->id, $verificacionDonante->donante->id);
    }

    /**
     * Test que verifica los resultados válidos.
     */
    public function test_resultados_validos(): void
    {
        $resultadosValidos = ['Aprobado', 'Observación', 'Rechazado'];
        
        foreach ($resultadosValidos as $resultado) {
            $donante = Donante::factory()->create();
            $verificacionDonante = VerificacionDonante::create([
                'donante_id' => $donante->id,
                'fecha_verificacion' => '2023-06-08',
                'resultado' => $resultado,
                'observaciones' => 'Observaciones de prueba',
            ]);

            $this->assertEquals($resultado, $verificacionDonante->resultado);
        }
    }

    /**
     * Test que verifica el cast de fecha.
     */
    public function test_fecha_verificacion_es_cast_a_date(): void
    {
        $donante = Donante::factory()->create();
        $verificacionDonante = VerificacionDonante::create([
            'donante_id' => $donante->id,
            'fecha_verificacion' => '2023-06-08',
            'resultado' => 'Aprobado',
            'observaciones' => 'Observaciones de prueba',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $verificacionDonante->fecha_verificacion);
    }

    /**
     * Test que verifica que las observaciones pueden ser nulas.
     */
    public function test_observaciones_pueden_ser_nulas(): void
    {
        $donante = Donante::factory()->create();
        $verificacionDonante = VerificacionDonante::create([
            'donante_id' => $donante->id,
            'fecha_verificacion' => '2023-06-08',
            'resultado' => 'Aprobado',
            'observaciones' => null,
        ]);

        $this->assertNull($verificacionDonante->observaciones);
    }

    /**
     * Test que verifica múltiples verificaciones para un donante.
     */
    public function test_donante_puede_tener_multiples_verificaciones(): void
    {
        $donante = Donante::factory()->create();
        
        $verificacion1 = VerificacionDonante::create([
            'donante_id' => $donante->id,
            'fecha_verificacion' => '2023-06-01',
            'resultado' => 'Observación',
            'observaciones' => 'Primera verificación',
        ]);

        $verificacion2 = VerificacionDonante::create([
            'donante_id' => $donante->id,
            'fecha_verificacion' => '2023-06-08',
            'resultado' => 'Aprobado',
            'observaciones' => 'Segunda verificación',
        ]);

        $this->assertEquals($donante->id, $verificacion1->donante_id);
        $this->assertEquals($donante->id, $verificacion2->donante_id);
        $this->assertNotEquals($verificacion1->id, $verificacion2->id);
    }
}
