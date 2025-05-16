<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DonanteService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Donantes",
 *     description="API Endpoints de donantes"
 * )
 */
class DonanteController extends Controller
{
    protected $donanteService;

    public function __construct(DonanteService $donanteService)
    {
        $this->donanteService = $donanteService;
    }

    /**
     * @OA\Get(
     *     path="/api/donantes",
     *     summary="Obtener todos los donantes",
     *     tags={"Donantes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de donantes obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $donantes = $this->donanteService->getAllDonantes();
            return response()->json([
                'success' => true,
                'data' => $donantes
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/donantes",
     *     summary="Crear un nuevo donante",
     *     tags={"Donantes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "correo", "telefono", "direccion", "tipo_documento", "numero_documento", "fecha_registro"},
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *             @OA\Property(property="correo", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="telefono", type="string", example="123456789"),
     *             @OA\Property(property="direccion", type="string", example="Calle Principal 123"),
     *             @OA\Property(property="tipo_documento", type="string", example="DNI"),
     *             @OA\Property(property="numero_documento", type="string", example="12345678"),
     *             @OA\Property(property="fecha_registro", type="string", format="date", example="2023-06-08"),
     *             @OA\Property(property="estado", type="string", example="Activo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Donante creado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $donante = $this->donanteService->createDonante($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Donante creado exitosamente',
                'data' => $donante
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/donantes/{id}",
     *     summary="Obtener un donante por ID",
     *     tags={"Donantes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Donante obtenido exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Donante no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $donante = $this->donanteService->getDonanteById($id);
            return response()->json([
                'success' => true,
                'data' => $donante
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/donantes/{id}",
     *     summary="Actualizar un donante existente",
     *     tags={"Donantes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez Actualizado"),
     *             @OA\Property(property="correo", type="string", format="email", example="juan.actualizado@example.com"),
     *             @OA\Property(property="telefono", type="string", example="987654321"),
     *             @OA\Property(property="direccion", type="string", example="Calle Secundaria 456"),
     *             @OA\Property(property="tipo_documento", type="string", example="DNI"),
     *             @OA\Property(property="numero_documento", type="string", example="87654321"),
     *             @OA\Property(property="fecha_registro", type="string", format="date", example="2023-06-08"),
     *             @OA\Property(property="estado", type="string", example="Inactivo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Donante actualizado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Donante no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $donante = $this->donanteService->updateDonante($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Donante actualizado exitosamente',
                'data' => $donante
            ], 200);
        } catch (Exception $e) {
            $statusCode = $e->getMessage() === 'Donante no encontrado' ? 404 : 400;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/donantes/{id}",
     *     summary="Eliminar un donante",
     *     tags={"Donantes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Donante eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Donante no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->donanteService->deleteDonante($id);
            return response()->json([
                'success' => true,
                'message' => 'Donante eliminado exitosamente'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/donantes/email/{email}",
     *     summary="Buscar donante por email",
     *     tags={"Donantes"},
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         description="Email del donante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Donante encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Donante no encontrado"
     *     )
     * )
     */
    public function findByEmail($email): JsonResponse
    {
        try {
            $donante = $this->donanteService->getDonanteByEmail($email);
            if (!$donante) {
                return response()->json([
                    'success' => false,
                    'message' => 'Donante no encontrado'
                ], 404);
            }
            return response()->json([
                'success' => true,
                'data' => $donante
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/donantes/activos",
     *     summary="Obtener donantes activos",
     *     tags={"Donantes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de donantes activos obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function getActiveDonantes(): JsonResponse
    {
        try {
            $donantes = $this->donanteService->getActiveDonantes();
            return response()->json([
                'success' => true,
                'data' => $donantes
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
