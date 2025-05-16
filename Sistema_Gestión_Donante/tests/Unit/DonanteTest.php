<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Donante;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonanteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que verifica la creación de un donante.
     */
    public function test_puede_crear_donante(): void
    {
        $donanteData = [
            'nombre' => 'Juan Pérez',
            'correo' => 'juan@example.com',
            'telefono' => '123456789',
            'direccion' => 'Calle Principal 123',
            'tipo_documento' => 'DNI',
            'numero_documento' => '12345678',
            'fecha_registro' => '2023-06-08',
            'estado' => 'Activo',
        ];

        $donante = Donante::create($donanteData);

        $this->assertInstanceOf(Donante::class, $donante);
        $this->assertEquals('Juan Pérez', $donante->nombre);
        $this->assertEquals('juan@example.com', $donante->correo);
        $this->assertEquals('Activo', $donante->estado);
    }

    /**
     * Test que verifica las relaciones del donante.
     */
    public function test_donante_tiene_relaciones(): void
    {
        $donante = new Donante();

        $this->assertTrue(method_exists($donante, 'mascotasDonadas'));
        $this->assertTrue(method_exists($donante, 'historialColaboraciones'));
        $this->assertTrue(method_exists($donante, 'informacionContactos'));
        $this->assertTrue(method_exists($donante, 'verificaciones'));
    }

    /**
     * Test que verifica los campos fillable.
     */
    public function test_donante_campos_fillable(): void
    {
        $donante = new Donante();
        $fillable = $donante->getFillable();

        $expectedFillable = [
            'nombre',
            'correo',
            'telefono',
            'direccion',
            'tipo_documento',
            'numero_documento',
            'fecha_registro',
            'estado'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }
}
