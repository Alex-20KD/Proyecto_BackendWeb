<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Donante;

class DonanteApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test para obtener todos los donantes.
     */
    public function test_puede_obtener_todos_los_donantes(): void
    {
        // Crear algunos donantes de prueba
        Donante::factory()->count(3)->create();

        $response = $this->getJson('/api/donantes');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'nombre',
                            'correo',
                            'telefono',
                            'direccion',
                            'tipo_documento',
                            'numero_documento',
                            'fecha_registro',
                            'estado',
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ]);
    }

    /**
     * Test para crear un nuevo donante.
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

        $response = $this->postJson('/api/donantes', $donanteData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data' => [
                        'id',
                        'nombre',
                        'correo',
                        'telefono',
                        'direccion',
                        'tipo_documento',
                        'numero_documento',
                        'fecha_registro',
                        'estado',
                        'created_at',
                        'updated_at'
                    ]
                ]);

        $this->assertDatabaseHas('donantes', [
            'nombre' => 'Juan Pérez',
            'correo' => 'juan@example.com'
        ]);
    }

    /**
     * Test para obtener un donante específico.
     */
    public function test_puede_obtener_donante_especifico(): void
    {
        $donante = Donante::factory()->create();

        $response = $this->getJson("/api/donantes/{$donante->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        'id',
                        'nombre',
                        'correo',
                        'telefono',
                        'direccion',
                        'tipo_documento',
                        'numero_documento',
                        'fecha_registro',
                        'estado',
                        'created_at',
                        'updated_at'
                    ]
                ]);
    }

    /**
     * Test para actualizar un donante.
     */
    public function test_puede_actualizar_donante(): void
    {
        $donante = Donante::factory()->create();

        $updateData = [
            'nombre' => 'Juan Pérez Actualizado',
            'telefono' => '987654321'
        ];

        $response = $this->putJson("/api/donantes/{$donante->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ]);

        $this->assertDatabaseHas('donantes', [
            'id' => $donante->id,
            'nombre' => 'Juan Pérez Actualizado',
            'telefono' => '987654321'
        ]);
    }

    /**
     * Test para eliminar un donante.
     */
    public function test_puede_eliminar_donante(): void
    {
        $donante = Donante::factory()->create();

        $response = $this->deleteJson("/api/donantes/{$donante->id}");

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message'
                ]);

        $this->assertDatabaseMissing('donantes', [
            'id' => $donante->id
        ]);
    }

    /**
     * Test para validación de datos requeridos.
     */
    public function test_validacion_datos_requeridos(): void
    {
        $response = $this->postJson('/api/donantes', []);

        $response->assertStatus(400)
                ->assertJsonStructure([
                    'success',
                    'message'
                ]);
    }

    /**
     * Test para email único.
     */
    public function test_email_debe_ser_unico(): void
    {
        $donante = Donante::factory()->create(['correo' => 'test@example.com']);

        $donanteData = [
            'nombre' => 'Otro Donante',
            'correo' => 'test@example.com', // Email duplicado
            'telefono' => '123456789',
            'direccion' => 'Calle Principal 123',
            'tipo_documento' => 'DNI',
            'numero_documento' => '87654321',
            'fecha_registro' => '2023-06-08',
            'estado' => 'Activo',
        ];

        $response = $this->postJson('/api/donantes', $donanteData);

        $response->assertStatus(400);
    }
}
