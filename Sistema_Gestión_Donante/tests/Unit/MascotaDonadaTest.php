<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\MascotaDonada;
use App\Models\Donante;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MascotaDonadaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que verifica la creación de una mascota donada.
     */
    public function test_puede_crear_mascota_donada(): void
    {
        // Crear un donante primero
        $donante = Donante::factory()->create();

        $mascotaDonadaData = [
            'donante_id' => $donante->id,
            'mascota_id' => 1,
            'fecha_donacion' => '2023-06-08',
            'motivo_donacion' => 'Me mudo a un apartamento que no permite mascotas',
            'estado_revision' => 'Pendiente',
        ];

        $mascotaDonada = MascotaDonada::create($mascotaDonadaData);

        $this->assertInstanceOf(MascotaDonada::class, $mascotaDonada);
        $this->assertEquals($donante->id, $mascotaDonada->donante_id);
        $this->assertEquals(1, $mascotaDonada->mascota_id);
        $this->assertEquals('Pendiente', $mascotaDonada->estado_revision);
    }

    /**
     * Test que verifica las relaciones de mascota donada.
     */
    public function test_mascota_donada_tiene_relaciones(): void
    {
        $mascotaDonada = new MascotaDonada();

        $this->assertTrue(method_exists($mascotaDonada, 'donante'));
        $this->assertTrue(method_exists($mascotaDonada, 'mascota'));
    }

    /**
     * Test que verifica los campos fillable.
     */
    public function test_mascota_donada_campos_fillable(): void
    {
        $mascotaDonada = new MascotaDonada();
        $fillable = $mascotaDonada->getFillable();

        $expectedFillable = [
            'donante_id',
            'mascota_id',
            'fecha_donacion',
            'motivo_donacion',
            'estado_revision'
        ];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /**
     * Test que verifica la relación con donante.
     */
    public function test_mascota_donada_pertenece_a_donante(): void
    {
        $donante = Donante::factory()->create();
        $mascotaDonada = MascotaDonada::factory()->create(['donante_id' => $donante->id]);

        $this->assertInstanceOf(Donante::class, $mascotaDonada->donante);
        $this->assertEquals($donante->id, $mascotaDonada->donante->id);
    }

    /**
     * Test que verifica los estados válidos.
     */
    public function test_estados_revision_validos(): void
    {
        $estadosValidos = ['Pendiente', 'Aceptada', 'Rechazada'];
        
        foreach ($estadosValidos as $estado) {
            $donante = Donante::factory()->create();
            $mascotaDonada = MascotaDonada::create([
                'donante_id' => $donante->id,
                'mascota_id' => 1,
                'fecha_donacion' => '2023-06-08',
                'motivo_donacion' => 'Motivo de prueba',
                'estado_revision' => $estado,
            ]);

            $this->assertEquals($estado, $mascotaDonada->estado_revision);
        }
    }

    /**
     * Test que verifica el cast de fecha.
     */
    public function test_fecha_donacion_es_cast_a_date(): void
    {
        $donante = Donante::factory()->create();
        $mascotaDonada = MascotaDonada::create([
            'donante_id' => $donante->id,
            'mascota_id' => 1,
            'fecha_donacion' => '2023-06-08',
            'motivo_donacion' => 'Motivo de prueba',
            'estado_revision' => 'Pendiente',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $mascotaDonada->fecha_donacion);
    }
}
