<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MascotaDonadaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Mascotas Donadas",
 *     description="API Endpoints de mascotas donadas"
 * )
 */
class MascotaDonadaController extends Controller
{
    protected $mascotaDonadaService;

    public function __construct(MascotaDonadaService $mascotaDonadaService)
    {
        $this->mascotaDonadaService = $mascotaDonadaService;
    }

    /**
     * @OA\Get(
     *     path="/api/mascotas-donadas",
     *     summary="Obtener todas las mascotas donadas",
     *     tags={"Mascotas Donadas"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de mascotas donadas obtenida exitosamente"
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
            $mascotasDonadas = $this->mascotaDonadaService->getAllMascotasDonadas();
            return response()->json([
                'success' => true,
                'data' => $mascotasDonadas
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
     *     path="/api/mascotas-donadas",
     *     summary="Crear una nueva mascota donada",
     *     tags={"Mascotas Donadas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"donante_id", "mascota_id", "fecha_donacion", "motivo_donacion"},
     *             @OA\Property(property="donante_id", type="integer", example=1),
     *             @OA\Property(property="mascota_id", type="integer", example=1),
     *             @OA\Property(property="fecha_donacion", type="string", format="date", example="2023-06-08"),
     *             @OA\Property(property="motivo_donacion", type="string", example="No puedo cuidarla más"),
     *             @OA\Property(property="estado_revision", type="string", example="Pendiente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Mascota donada creada exitosamente"
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
            $mascotaDonada = $this->mascotaDonadaService->createMascotaDonada($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Mascota donada creada exitosamente',
                'data' => $mascotaDonada
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
     *     path="/api/mascotas-donadas/{id}",
     *     summary="Obtener una mascota donada por ID",
     *     tags={"Mascotas Donadas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota donada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mascota donada obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mascota donada no encontrada"
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
            $mascotaDonada = $this->mascotaDonadaService->getMascotaDonadaById($id);
            return response()->json([
                'success' => true,
                'data' => $mascotaDonada
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
     *     path="/api/mascotas-donadas/{id}",
     *     summary="Actualizar una mascota donada existente",
     *     tags={"Mascotas Donadas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota donada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="donante_id", type="integer", example=1),
     *             @OA\Property(property="mascota_id", type="integer", example=1),
     *             @OA\Property(property="fecha_donacion", type="string", format="date", example="2023-06-08"),
     *             @OA\Property(property="motivo_donacion", type="string", example="Motivo actualizado"),
     *             @OA\Property(property="estado_revision", type="string", example="Aceptada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mascota donada actualizada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mascota donada no encontrada"
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
            $mascotaDonada = $this->mascotaDonadaService->updateMascotaDonada($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Mascota donada actualizada exitosamente',
                'data' => $mascotaDonada
            ], 200);
        } catch (Exception $e) {
            $statusCode = $e->getMessage() === 'Mascota donada no encontrada' ? 404 : 400;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/mascotas-donadas/{id}",
     *     summary="Eliminar una mascota donada",
     *     tags={"Mascotas Donadas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la mascota donada",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mascota donada eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mascota donada no encontrada"
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
            $this->mascotaDonadaService->deleteMascotaDonada($id);
            return response()->json([
                'success' => true,
                'message' => 'Mascota donada eliminada exitosamente'
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
     *     path="/api/mascotas-donadas/donante/{donanteId}",
     *     summary="Obtener mascotas donadas por donante",
     *     tags={"Mascotas Donadas"},
     *     @OA\Parameter(
     *         name="donanteId",
     *         in="path",
     *         required=true,
     *         description="ID del donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de mascotas donadas por donante obtenida exitosamente"
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
            $mascotasDonadas = $this->mascotaDonadaService->getMascotasDonadasByDonante($donanteId);
            return response()->json([
                'success' => true,
                'data' => $mascotasDonadas
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
     *     path="/api/mascotas-donadas/estado/{estado}",
     *     summary="Obtener mascotas donadas por estado",
     *     tags={"Mascotas Donadas"},
     *     @OA\Parameter(
     *         name="estado",
     *         in="path",
     *         required=true,
     *         description="Estado de revisión",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de mascotas donadas por estado obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function getByEstado($estado): JsonResponse
    {
        try {
            $mascotasDonadas = $this->mascotaDonadaService->getMascotasDonadasByEstado($estado);
            return response()->json([
                'success' => true,
                'data' => $mascotasDonadas
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
