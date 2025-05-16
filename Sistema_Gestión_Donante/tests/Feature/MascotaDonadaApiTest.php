<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\MascotaDonada;
use App\Models\Donante;

class MascotaDonadaApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test para obtener todas las mascotas donadas.
     */
    public function test_puede_obtener_todas_las_mascotas_donadas(): void
    {
        // Crear algunos donantes y mascotas donadas de prueba
        $donante = Donante::factory()->create();
        MascotaDonada::factory()->count(3)->create(['donante_id' => $donante->id]);

        $response = $this->getJson('/api/mascotas-donadas');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'mascota_id',
                            'fecha_donacion',
                            'motivo_donacion',
                            'estado_revision',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]);
    }

    /**
     * Test para crear una nueva mascota donada.
     */
    public function test_puede_crear_mascota_donada(): void
    {
        $donante = Donante::factory()->create();
        
        $mascotaDonadaData = [
            'donante_id' => $donante->id,
            'mascota_id' => 1,
            'fecha_donacion' => '2023-06-08',
            'motivo_donacion' => 'Me mudo a un apartamento que no permite mascotas',
            'estado_revision' => 'Pendiente',
        ];

        $response = $this->postJson('/api/mascotas-donadas', $mascotaDonadaData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'donante_id',
                        'mascota_id',
                        'fecha_donacion',
                        'motivo_donacion',
                        'estado_revision',
                        'created_at',
                        'updated_at'
                    ]
                ]);

        $this->assertDatabaseHas('mascotas_donadas', [
            'donante_id' => $donante->id,
            'mascota_id' => 1,
            'motivo_donacion' => 'Me mudo a un apartamento que no permite mascotas'
        ]);
    }

    /**
     * Test para obtener una mascota donada específica.
     */
    public function test_puede_obtener_mascota_donada_especifica(): void
    {
        $donante = Donante::factory()->create();
        $mascotaDonada = MascotaDonada::factory()->create(['donante_id' => $donante->id]);

        $response = $this->getJson("/api/mascotas-donadas/{$mascotaDonada->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'donante_id',
                        'mascota_id',
                        'fecha_donacion',
                        'motivo_donacion',
                        'estado_revision',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    /**
     * Test para actualizar una mascota donada.
     */
    public function test_puede_actualizar_mascota_donada(): void
    {
        $donante = Donante::factory()->create();
        $mascotaDonada = MascotaDonada::factory()->create(['donante_id' => $donante->id]);

        $updateData = [
            'motivo_donacion' => 'Motivo actualizado',
            'estado_revision' => 'Aceptada'
        ];

        $response = $this->putJson("/api/mascotas-donadas/{$mascotaDonada->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ]);

        $this->assertDatabaseHas('mascotas_donadas', [
            'id' => $mascotaDonada->id,
            'motivo_donacion' => 'Motivo actualizado',
            'estado_revision' => 'Aceptada'
        ]);
    }

    /**
     * Test para eliminar una mascota donada.
     */
    public function test_puede_eliminar_mascota_donada(): void
    {
        $donante = Donante::factory()->create();
        $mascotaDonada = MascotaDonada::factory()->create(['donante_id' => $donante->id]);

        $response = $this->deleteJson("/api/mascotas-donadas/{$mascotaDonada->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message'
                ]);

        $this->assertDatabaseMissing('mascotas_donadas', [
            'id' => $mascotaDonada->id
        ]);
    }

    /**
     * Test para obtener mascotas donadas por donante.
     */
    public function test_puede_obtener_mascotas_donadas_por_donante(): void
    {
        $donante = Donante::factory()->create();
        MascotaDonada::factory()->count(2)->create(['donante_id' => $donante->id]);

        $response = $this->getJson("/api/mascotas-donadas/donante/{$donante->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'mascota_id',
                            'fecha_donacion',
                            'motivo_donacion',
                            'estado_revision'
                        ]
                    ]
                ]);
    }

    /**
     * Test para obtener mascotas donadas por estado.
     */
    public function test_puede_obtener_mascotas_donadas_por_estado(): void
    {
        $donante = Donante::factory()->create();
        MascotaDonada::factory()->count(2)->create([
            'donante_id' => $donante->id,
            'estado_revision' => 'Pendiente'
        ]);

        $response = $this->getJson('/api/mascotas-donadas/estado/Pendiente');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'mascota_id',
                            'estado_revision'
                        ]
                    ]
                ]);
    }

    /**
     * Test para validación de datos requeridos.
     */
    public function test_validacion_datos_requeridos(): void
    {
        $response = $this->postJson('/api/mascotas-donadas', []);

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
        $mascotaDonadaData = [
            'donante_id' => 999, // ID que no existe
            'mascota_id' => 1,
            'fecha_donacion' => '2023-06-08',
            'motivo_donacion' => 'Motivo de prueba',
            'estado_revision' => 'Pendiente',
        ];

        $response = $this->postJson('/api/mascotas-donadas', $mascotaDonadaData);

        $response->assertStatus(400);
    }
}
