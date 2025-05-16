<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\HistorialColaboracion;
use App\Models\Donante;

class HistorialColaboracionApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test para obtener todo el historial de colaboraciones.
     */
    public function test_puede_obtener_todo_el_historial_colaboraciones(): void
    {
        // Crear algunos donantes e historial de colaboraciones de prueba
        $donante = Donante::factory()->create();
        HistorialColaboracion::factory()->count(3)->create(['donante_id' => $donante->id]);

        $response = $this->getJson('/api/historial-colaboraciones');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'tipo_colaboracion',
                            'descripcion',
                            'fecha_colaboracion',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]);
    }

    /**
     * Test para crear una nueva colaboración.
     */
    public function test_puede_crear_historial_colaboracion(): void
    {
        $donante = Donante::factory()->create();
        
        $historialColaboracionData = [
            'donante_id' => $donante->id,
            'tipo_colaboracion' => 'Económica',
            'descripcion' => 'Donación de $100 para alimento de mascotas',
            'fecha_colaboracion' => '2023-06-08',
        ];

        $response = $this->postJson('/api/historial-colaboraciones', $historialColaboracionData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'donante_id',
                        'tipo_colaboracion',
                        'descripcion',
                        'fecha_colaboracion',
                        'created_at',
                        'updated_at'
                    ]
                ]);

        $this->assertDatabaseHas('historial_colaboraciones', [
            'donante_id' => $donante->id,
            'tipo_colaboracion' => 'Económica',
            'descripcion' => 'Donación de $100 para alimento de mascotas'
        ]);
    }

    /**
     * Test para obtener una colaboración específica.
     */
    public function test_puede_obtener_historial_colaboracion_especifica(): void
    {
        $donante = Donante::factory()->create();
        $historialColaboracion = HistorialColaboracion::factory()->create(['donante_id' => $donante->id]);

        $response = $this->getJson("/api/historial-colaboraciones/{$historialColaboracion->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'donante_id',
                        'tipo_colaboracion',
                        'descripcion',
                        'fecha_colaboracion',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    /**
     * Test para actualizar una colaboración.
     */
    public function test_puede_actualizar_historial_colaboracion(): void
    {
        $donante = Donante::factory()->create();
        $historialColaboracion = HistorialColaboracion::factory()->create(['donante_id' => $donante->id]);

        $updateData = [
            'tipo_colaboracion' => 'Voluntariado',
            'descripcion' => 'Descripción actualizada'
        ];

        $response = $this->putJson("/api/historial-colaboraciones/{$historialColaboracion->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ]);

        $this->assertDatabaseHas('historial_colaboraciones', [
            'id' => $historialColaboracion->id,
            'tipo_colaboracion' => 'Voluntariado',
            'descripcion' => 'Descripción actualizada'
        ]);
    }

    /**
     * Test para eliminar una colaboración.
     */
    public function test_puede_eliminar_historial_colaboracion(): void
    {
        $donante = Donante::factory()->create();
        $historialColaboracion = HistorialColaboracion::factory()->create(['donante_id' => $donante->id]);

        $response = $this->deleteJson("/api/historial-colaboraciones/{$historialColaboracion->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message'
                ]);

        $this->assertDatabaseMissing('historial_colaboraciones', [
            'id' => $historialColaboracion->id
        ]);
    }

    /**
     * Test para obtener colaboraciones por donante.
     */
    public function test_puede_obtener_historial_colaboraciones_por_donante(): void
    {
        $donante = Donante::factory()->create();
        HistorialColaboracion::factory()->count(2)->create(['donante_id' => $donante->id]);

        $response = $this->getJson("/api/historial-colaboraciones/donante/{$donante->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'tipo_colaboracion',
                            'descripcion',
                            'fecha_colaboracion'
                        ]
                    ]
                ]);
    }

    /**
     * Test para obtener colaboraciones por tipo.
     */
    public function test_puede_obtener_historial_colaboraciones_por_tipo(): void
    {
        $donante = Donante::factory()->create();
        HistorialColaboracion::factory()->count(2)->create([
            'donante_id' => $donante->id,
            'tipo_colaboracion' => 'Económica'
        ]);

        $response = $this->getJson('/api/historial-colaboraciones/tipo/Económica');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'tipo_colaboracion',
                            'descripcion'
                        ]
                    ]
                ]);
    }

    /**
     * Test para validación de datos requeridos.
     */
    public function test_validacion_datos_requeridos(): void
    {
        $response = $this->postJson('/api/historial-colaboraciones', []);

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
        $historialColaboracionData = [
            'donante_id' => 999, // ID que no existe
            'tipo_colaboracion' => 'Económica',
            'descripcion' => 'Descripción de prueba',
            'fecha_colaboracion' => '2023-06-08',
        ];

        $response = $this->postJson('/api/historial-colaboraciones', $historialColaboracionData);

        $response->assertStatus(400);
    }
}
