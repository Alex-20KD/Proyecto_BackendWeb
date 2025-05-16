<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\HistorialColaboracionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Historial Colaboraciones",
 *     description="API Endpoints de historial de colaboraciones"
 * )
 */
class HistorialColaboracionController extends Controller
{
    protected $historialColaboracionService;

    public function __construct(HistorialColaboracionService $historialColaboracionService)
    {
        $this->historialColaboracionService = $historialColaboracionService;
    }

    /**
     * @OA\Get(
     *     path="/api/historial-colaboraciones",
     *     summary="Obtener todo el historial de colaboraciones",
     *     tags={"Historial Colaboraciones"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de historial de colaboraciones obtenida exitosamente"
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
            $historialColaboraciones = $this->historialColaboracionService->getAllHistorialColaboraciones();
            return response()->json([
                'success' => true,
                'data' => $historialColaboraciones
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
     *     path="/api/historial-colaboraciones",
     *     summary="Crear una nueva colaboración",
     *     tags={"Historial Colaboraciones"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"donante_id", "tipo_colaboracion", "descripcion", "fecha_colaboracion"},
     *             @OA\Property(property="donante_id", type="integer", example=1),
     *             @OA\Property(property="tipo_colaboracion", type="string", example="Económica"),
     *             @OA\Property(property="descripcion", type="string", example="Donación monetaria para alimento"),
     *             @OA\Property(property="fecha_colaboracion", type="string", format="date", example="2023-06-08")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Colaboración creada exitosamente"
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
            $historialColaboracion = $this->historialColaboracionService->createHistorialColaboracion($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Colaboración creada exitosamente',
                'data' => $historialColaboracion
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
     *     path="/api/historial-colaboraciones/{id}",
     *     summary="Obtener una colaboración por ID",
     *     tags={"Historial Colaboraciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la colaboración",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Colaboración obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Colaboración no encontrada"
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
            $historialColaboracion = $this->historialColaboracionService->getHistorialColaboracionById($id);
            return response()->json([
                'success' => true,
                'data' => $historialColaboracion
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
     *     path="/api/historial-colaboraciones/{id}",
     *     summary="Actualizar una colaboración existente",
     *     tags={"Historial Colaboraciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la colaboración",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="donante_id", type="integer", example=1),
     *             @OA\Property(property="tipo_colaboracion", type="string", example="Voluntariado"),
     *             @OA\Property(property="descripcion", type="string", example="Descripción actualizada"),
     *             @OA\Property(property="fecha_colaboracion", type="string", format="date", example="2023-06-08")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Colaboración actualizada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Colaboración no encontrada"
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
            $historialColaboracion = $this->historialColaboracionService->updateHistorialColaboracion($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Colaboración actualizada exitosamente',
                'data' => $historialColaboracion
            ], 200);
        } catch (Exception $e) {
            $statusCode = $e->getMessage() === 'Historial de colaboración no encontrado' ? 404 : 400;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/historial-colaboraciones/{id}",
     *     summary="Eliminar una colaboración",
     *     tags={"Historial Colaboraciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la colaboración",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Colaboración eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Colaboración no encontrada"
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
            $this->historialColaboracionService->deleteHistorialColaboracion($id);
            return response()->json([
                'success' => true,
                'message' => 'Colaboración eliminada exitosamente'
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
     *     path="/api/historial-colaboraciones/donante/{donanteId}",
     *     summary="Obtener colaboraciones por donante",
     *     tags={"Historial Colaboraciones"},
     *     @OA\Parameter(
     *         name="donanteId",
     *         in="path",
     *         required=true,
     *         description="ID del donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de colaboraciones por donante obtenida exitosamente"
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
            $historialColaboraciones = $this->historialColaboracionService->getHistorialColaboracionByDonante($donanteId);
            return response()->json([
                'success' => true,
                'data' => $historialColaboraciones
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
     *     path="/api/historial-colaboraciones/tipo/{tipo}",
     *     summary="Obtener colaboraciones por tipo",
     *     tags={"Historial Colaboraciones"},
     *     @OA\Parameter(
     *         name="tipo",
     *         in="path",
     *         required=true,
     *         description="Tipo de colaboración",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de colaboraciones por tipo obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function getByTipo($tipo): JsonResponse
    {
        try {
            $historialColaboraciones = $this->historialColaboracionService->getHistorialColaboracionByTipo($tipo);
            return response()->json([
                'success' => true,
                'data' => $historialColaboraciones
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
