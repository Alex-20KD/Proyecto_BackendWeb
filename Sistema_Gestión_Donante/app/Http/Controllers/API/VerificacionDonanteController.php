<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\VerificacionDonanteService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Verificaciones Donantes",
 *     description="API Endpoints de verificaciones de donantes"
 * )
 */
class VerificacionDonanteController extends Controller
{
    protected $verificacionDonanteService;

    public function __construct(VerificacionDonanteService $verificacionDonanteService)
    {
        $this->verificacionDonanteService = $verificacionDonanteService;
    }

    /**
     * @OA\Get(
     *     path="/api/verificaciones-donantes",
     *     summary="Obtener todas las verificaciones de donantes",
     *     tags={"Verificaciones Donantes"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de verificaciones de donantes obtenida exitosamente"
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
            $verificacionesDonantes = $this->verificacionDonanteService->getAllVerificacionesDonantes();
            return response()->json([
                'success' => true,
                'data' => $verificacionesDonantes
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
     *     path="/api/verificaciones-donantes",
     *     summary="Crear nueva verificación de donante",
     *     tags={"Verificaciones Donantes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"donante_id", "fecha_verificacion", "resultado"},
     *             @OA\Property(property="donante_id", type="integer", example=1),
     *             @OA\Property(property="fecha_verificacion", type="string", format="date", example="2023-06-08"),
     *             @OA\Property(property="resultado", type="string", example="Aprobado"),
     *             @OA\Property(property="observaciones", type="string", example="Documentos en orden, domicilio verificado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Verificación de donante creada exitosamente"
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
            $verificacionDonante = $this->verificacionDonanteService->createVerificacionDonante($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Verificación de donante creada exitosamente',
                'data' => $verificacionDonante
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
     *     path="/api/verificaciones-donantes/{id}",
     *     summary="Obtener verificación de donante por ID",
     *     tags={"Verificaciones Donantes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la verificación de donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Verificación de donante obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Verificación de donante no encontrada"
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
            $verificacionDonante = $this->verificacionDonanteService->getVerificacionDonanteById($id);
            return response()->json([
                'success' => true,
                'data' => $verificacionDonante
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
     *     path="/api/verificaciones-donantes/{id}",
     *     summary="Actualizar verificación de donante existente",
     *     tags={"Verificaciones Donantes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la verificación de donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="donante_id", type="integer", example=1),
     *             @OA\Property(property="fecha_verificacion", type="string", format="date", example="2023-06-08"),
     *             @OA\Property(property="resultado", type="string", example="Observación"),
     *             @OA\Property(property="observaciones", type="string", example="Requiere documentación adicional")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Verificación de donante actualizada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Verificación de donante no encontrada"
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
            $verificacionDonante = $this->verificacionDonanteService->updateVerificacionDonante($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Verificación de donante actualizada exitosamente',
                'data' => $verificacionDonante
            ], 200);
        } catch (Exception $e) {
            $statusCode = $e->getMessage() === 'Verificación de donante no encontrada' ? 404 : 400;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/verificaciones-donantes/{id}",
     *     summary="Eliminar verificación de donante",
     *     tags={"Verificaciones Donantes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la verificación de donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Verificación de donante eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Verificación de donante no encontrada"
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
            $this->verificacionDonanteService->deleteVerificacionDonante($id);
            return response()->json([
                'success' => true,
                'message' => 'Verificación de donante eliminada exitosamente'
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
     *     path="/api/verificaciones-donantes/donante/{donanteId}",
     *     summary="Obtener verificaciones por donante",
     *     tags={"Verificaciones Donantes"},
     *     @OA\Parameter(
     *         name="donanteId",
     *         in="path",
     *         required=true,
     *         description="ID del donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de verificaciones por donante obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function getByDonante($donanteId): JsonResponse
    {
        try {
            $verificacionesDonantes = $this->verificacionDonanteService->getVerificacionDonanteByDonante($donanteId);
            return response()->json([
                'success' => true,
                'data' => $verificacionesDonantes
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
     *     path="/api/verificaciones-donantes/resultado/{resultado}",
     *     summary="Obtener verificaciones por resultado",
     *     tags={"Verificaciones Donantes"},
     *     @OA\Parameter(
     *         name="resultado",
     *         in="path",
     *         required=true,
     *         description="Resultado de la verificación",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de verificaciones por resultado obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function getByResultado($resultado): JsonResponse
    {
        try {
            $verificacionesDonantes = $this->verificacionDonanteService->getVerificacionDonanteByResultado($resultado);
            return response()->json([
                'success' => true,
                'data' => $verificacionesDonantes
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
