<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\InformacionContacto;
use App\Models\Donante;

class InformacionContactoApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test para obtener toda la información de contactos.
     */
    public function test_puede_obtener_toda_la_informacion_contactos(): void
    {
        // Crear algunos donantes e información de contactos de prueba
        $donante = Donante::factory()->create();
        InformacionContacto::factory()->count(3)->create(['donante_id' => $donante->id]);

        $response = $this->getJson('/api/informacion-contactos');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'nombre_contacto',
                            'telefono',
                            'relacion',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]);
    }

    /**
     * Test para crear nueva información de contacto.
     */
    public function test_puede_crear_informacion_contacto(): void
    {
        $donante = Donante::factory()->create();
        
        $informacionContactoData = [
            'donante_id' => $donante->id,
            'nombre_contacto' => 'Pedro García',
            'telefono' => '555-0201',
            'relacion' => 'Hermano',
        ];

        $response = $this->postJson('/api/informacion-contactos', $informacionContactoData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'donante_id',
                        'nombre_contacto',
                        'telefono',
                        'relacion',
                        'created_at',
                        'updated_at'
                    ]
                ]);

        $this->assertDatabaseHas('informacion_contactos', [
            'donante_id' => $donante->id,
            'nombre_contacto' => 'Pedro García',
            'telefono' => '555-0201',
            'relacion' => 'Hermano'
        ]);
    }

    /**
     * Test para obtener información de contacto específica.
     */
    public function test_puede_obtener_informacion_contacto_especifica(): void
    {
        $donante = Donante::factory()->create();
        $informacionContacto = InformacionContacto::factory()->create(['donante_id' => $donante->id]);

        $response = $this->getJson("/api/informacion-contactos/{$informacionContacto->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'donante_id',
                        'nombre_contacto',
                        'telefono',
                        'relacion',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    /**
     * Test para actualizar información de contacto.
     */
    public function test_puede_actualizar_informacion_contacto(): void
    {
        $donante = Donante::factory()->create();
        $informacionContacto = InformacionContacto::factory()->create(['donante_id' => $donante->id]);

        $updateData = [
            'nombre_contacto' => 'Pedro García Actualizado',
            'telefono' => '555-9999'
        ];

        $response = $this->putJson("/api/informacion-contactos/{$informacionContacto->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ]);

        $this->assertDatabaseHas('informacion_contactos', [
            'id' => $informacionContacto->id,
            'nombre_contacto' => 'Pedro García Actualizado',
            'telefono' => '555-9999'
        ]);
    }

    /**
     * Test para eliminar información de contacto.
     */
    public function test_puede_eliminar_informacion_contacto(): void
    {
        $donante = Donante::factory()->create();
        $informacionContacto = InformacionContacto::factory()->create(['donante_id' => $donante->id]);

        $response = $this->deleteJson("/api/informacion-contactos/{$informacionContacto->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message'
                ]);

        $this->assertDatabaseMissing('informacion_contactos', [
            'id' => $informacionContacto->id
        ]);
    }

    /**
     * Test para obtener información de contacto por donante.
     */
    public function test_puede_obtener_informacion_contacto_por_donante(): void
    {
        $donante = Donante::factory()->create();
        InformacionContacto::factory()->count(2)->create(['donante_id' => $donante->id]);

        $response = $this->getJson("/api/informacion-contactos/donante/{$donante->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'donante_id',
                            'nombre_contacto',
                            'telefono',
                            'relacion'
                        ]
                    ]
                ]);
    }

    /**
     * Test para validación de datos requeridos.
     */
    public function test_validacion_datos_requeridos(): void
    {
        $response = $this->postJson('/api/informacion-contactos', []);

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
        $informacionContactoData = [
            'donante_id' => 999, // ID que no existe
            'nombre_contacto' => 'Pedro García',
            'telefono' => '555-0201',
            'relacion' => 'Hermano',
        ];

        $response = $this->postJson('/api/informacion-contactos', $informacionContactoData);

        $response->assertStatus(400);
    }

    /**
     * Test para múltiples contactos del mismo donante.
     */
    public function test_donante_puede_tener_multiples_contactos(): void
    {
        $donante = Donante::factory()->create();
        
        $contacto1Data = [
            'donante_id' => $donante->id,
            'nombre_contacto' => 'Pedro García',
            'telefono' => '555-0001',
            'relacion' => 'Hermano',
        ];

        $contacto2Data = [
            'donante_id' => $donante->id,
            'nombre_contacto' => 'Ana García',
            'telefono' => '555-0002',
            'relacion' => 'Madre',
        ];

        $response1 = $this->postJson('/api/informacion-contactos', $contacto1Data);
        $response2 = $this->postJson('/api/informacion-contactos', $contacto2Data);

        $response1->assertStatus(201);
        $response2->assertStatus(201);

        $this->assertDatabaseHas('informacion_contactos', $contacto1Data);
        $this->assertDatabaseHas('informacion_contactos', $contacto2Data);
    }
}
