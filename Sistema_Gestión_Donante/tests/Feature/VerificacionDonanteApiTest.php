<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\VerificacionDonante;
use App\Models\Donante;

class VerificacionDonanteApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test para obtener todas las verificaciones de donantes.
     */
    public function test_puede_obtener_todas_las_verificaciones_donantes(): void
    {
        // Crear algunos donantes y verificaciones de prueba
        $donante = Donante::factory()->create();
        VerificacionDonante::factory()->count(3)->create(['donante_id' => $donante->id]);

        $response = $this->getJson('/api/verificaciones-donantes');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'fecha_verificacion',
                            'resultado',
                            'observaciones',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]);
    }

    /**
     * Test para crear nueva verificación de donante.
     */
    public function test_puede_crear_verificacion_donante(): void
    {
        $donante = Donante::factory()->create();
        
        $verificacionDonanteData = [
            'donante_id' => $donante->id,
            'fecha_verificacion' => '2023-06-08',
            'resultado' => 'Aprobado',
            'observaciones' => 'Documentos en orden, domicilio verificado',
        ];

        $response = $this->postJson('/api/verificaciones-donantes', $verificacionDonanteData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'donante_id',
                        'fecha_verificacion',
                        'resultado',
                        'observaciones',
                        'created_at',
                        'updated_at'
                    ]
                ]);

        $this->assertDatabaseHas('verificaciones_donantes', [
            'donante_id' => $donante->id,
            'resultado' => 'Aprobado',
            'observaciones' => 'Documentos en orden, domicilio verificado'
        ]);
    }

    /**
     * Test para obtener verificación de donante específica.
     */
    public function test_puede_obtener_verificacion_donante_especifica(): void
    {
        $donante = Donante::factory()->create();
        $verificacionDonante = VerificacionDonante::factory()->create(['donante_id' => $donante->id]);

        $response = $this->getJson("/api/verificaciones-donantes/{$verificacionDonante->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'donante_id',
                        'fecha_verificacion',
                        'resultado',
                        'observaciones',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    /**
     * Test para actualizar verificación de donante.
     */
    public function test_puede_actualizar_verificacion_donante(): void
    {
        $donante = Donante::factory()->create();
        $verificacionDonante = VerificacionDonante::factory()->create(['donante_id' => $donante->id]);

        $updateData = [
            'resultado' => 'Observación',
            'observaciones' => 'Requiere documentación adicional'
        ];

        $response = $this->putJson("/api/verificaciones-donantes/{$verificacionDonante->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ]);

        $this->assertDatabaseHas('verificaciones_donantes', [
            'id' => $verificacionDonante->id,
            'resultado' => 'Observación',
            'observaciones' => 'Requiere documentación adicional'
        ]);
    }

    /**
     * Test para eliminar verificación de donante.
     */
    public function test_puede_eliminar_verificacion_donante(): void
    {
        $donante = Donante::factory()->create();
        $verificacionDonante = VerificacionDonante::factory()->create(['donante_id' => $donante->id]);

        $response = $this->deleteJson("/api/verificaciones-donantes/{$verificacionDonante->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message'
                ]);

        $this->assertDatabaseMissing('verificaciones_donantes', [
            'id' => $verificacionDonante->id
        ]);
    }

    /**
     * Test para obtener verificaciones por donante.
     */
    public function test_puede_obtener_verificaciones_por_donante(): void
    {
        $donante = Donante::factory()->create();
        VerificacionDonante::factory()->count(2)->create(['donante_id' => $donante->id]);

        $response = $this->getJson("/api/verificaciones-donantes/donante/{$donante->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'fecha_verificacion',
                            'resultado',
                            'observaciones'
                        ]
                    ]
                ]);
    }

    /**
     * Test para obtener verificaciones por resultado.
     */
    public function test_puede_obtener_verificaciones_por_resultado(): void
    {
        $donante = Donante::factory()->create();
        VerificacionDonante::factory()->count(2)->create([
            'donante_id' => $donante->id,
            'resultado' => 'Aprobado'
        ]);

        $response = $this->getJson('/api/verificaciones-donantes/resultado/Aprobado');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'resultado',
                            'observaciones'
                        ]
                    ]
                ]);
    }

    /**
     * Test para validación de datos requeridos.
     */
    public function test_validacion_datos_requeridos(): void
    {
        $response = $this->postJson('/api/verificaciones-donantes', []);

        $response->assertStatus(400)
                ->assertJsonStructure([
                    'success',
                    'message'
                ]);
    }

    /**
     * Test para donante inexistente.
     */
    public function test_error_donante_inexistente(): void
    {
        $verificacionDonanteData = [
            'donante_id' => 999, // ID que no existe
            'fecha_verificacion' => '2023-06-08',
            'resultado' => 'Aprobado',
            'observaciones' => 'Observaciones de prueba',
        ];

        $response = $this->postJson('/api/verificaciones-donantes', $verificacionDonanteData);

        $response->assertStatus(400);
    }

    /**
     * Test para resultados válidos.
     */
    public function test_resultados_validos(): void
    {
        $donante = Donante::factory()->create();
        $resultadosValidos = ['Aprobado', 'Observación', 'Rechazado'];

        foreach ($resultadosValidos as $resultado) {
            $verificacionData = [
                'donante_id' => $donante->id,
                'fecha_verificacion' => '2023-06-08',
                'resultado' => $resultado,
                'observaciones' => 'Observaciones de prueba',
            ];

            $response = $this->postJson('/api/verificaciones-donantes', $verificacionData);
            $response->assertStatus(201);
        }
    }

    /**
     * Test para múltiples verificaciones del mismo donante.
     */
    public function test_donante_puede_tener_multiples_verificaciones(): void
    {
        $donante = Donante::factory()->create();
        
        $verificacion1Data = [
            'donante_id' => $donante->id,
            'fecha_verificacion' => '2023-06-01',
            'resultado' => 'Observación',
            'observaciones' => 'Primera verificación',
        ];

        $verificacion2Data = [
            'donante_id' => $donante->id,
            'fecha_verificacion' => '2023-06-08',
            'resultado' => 'Aprobado',
            'observaciones' => 'Segunda verificación',
        ];

        $response1 = $this->postJson('/api/verificaciones-donantes', $verificacion1Data);
        $response2 = $this->postJson('/api/verificaciones-donantes', $verificacion2Data);

        $response1->assertStatus(201);
        $response2->assertStatus(201);

        $this->assertDatabaseHas('verificaciones_donantes', $verificacion1Data);
        $this->assertDatabaseHas('verificaciones_donantes', $verificacion2Data);
    }
}
