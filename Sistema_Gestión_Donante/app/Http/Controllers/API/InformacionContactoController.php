<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\InformacionContactoService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Información Contacto",
 *     description="API Endpoints de información de contacto"
 * )
 */
class InformacionContactoController extends Controller
{
    protected $informacionContactoService;

    public function __construct(InformacionContactoService $informacionContactoService)
    {
        $this->informacionContactoService = $informacionContactoService;
    }

    /**
     * @OA\Get(
     *     path="/api/informacion-contactos",
     *     summary="Obtener toda la información de contactos",
     *     tags={"Información Contacto"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de información de contactos obtenida exitosamente"
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
            $informacionContactos = $this->informacionContactoService->getAllInformacionContactos();
            return response()->json([
                'success' => true,
                'data' => $informacionContactos
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
     *     path="/api/informacion-contactos",
     *     summary="Crear nueva información de contacto",
     *     tags={"Información Contacto"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"donante_id", "nombre_contacto", "telefono", "relacion"},
     *             @OA\Property(property="donante_id", type="integer", example=1),
     *             @OA\Property(property="nombre_contacto", type="string", example="Pedro García"),
     *             @OA\Property(property="telefono", type="string", example="555-0201"),
     *             @OA\Property(property="relacion", type="string", example="Hermano")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Información de contacto creada exitosamente"
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
            $informacionContacto = $this->informacionContactoService->createInformacionContacto($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Información de contacto creada exitosamente',
                'data' => $informacionContacto
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
     *     path="/api/informacion-contactos/{id}",
     *     summary="Obtener información de contacto por ID",
     *     tags={"Información Contacto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la información de contacto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Información de contacto obtenida exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Información de contacto no encontrada"
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
            $informacionContacto = $this->informacionContactoService->getInformacionContactoById($id);
            return response()->json([
                'success' => true,
                'data' => $informacionContacto
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
     *     path="/api/informacion-contactos/{id}",
     *     summary="Actualizar información de contacto existente",
     *     tags={"Información Contacto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la información de contacto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="donante_id", type="integer", example=1),
     *             @OA\Property(property="nombre_contacto", type="string", example="Pedro García Actualizado"),
     *             @OA\Property(property="telefono", type="string", example="555-9999"),
     *             @OA\Property(property="relacion", type="string", example="Primo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Información de contacto actualizada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Datos inválidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Información de contacto no encontrada"
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
            $informacionContacto = $this->informacionContactoService->updateInformacionContacto($id, $request->all());
            return response()->json([
                'success' => true,
                'message' => 'Información de contacto actualizada exitosamente',
                'data' => $informacionContacto
            ], 200);
        } catch (Exception $e) {
            $statusCode = $e->getMessage() === 'Información de contacto no encontrada' ? 404 : 400;
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], $statusCode);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/informacion-contactos/{id}",
     *     summary="Eliminar información de contacto",
     *     tags={"Información Contacto"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la información de contacto",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Información de contacto eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Información de contacto no encontrada"
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
            $this->informacionContactoService->deleteInformacionContacto($id);
            return response()->json([
                'success' => true,
                'message' => 'Información de contacto eliminada exitosamente'
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
     *     path="/api/informacion-contactos/donante/{donanteId}",
     *     summary="Obtener información de contacto por donante",
     *     tags={"Información Contacto"},
     *     @OA\Parameter(
     *         name="donanteId",
     *         in="path",
     *         required=true,
     *         description="ID del donante",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de información de contacto por donante obtenida exitosamente"
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
            $informacionContactos = $this->informacionContactoService->getInformacionContactoByDonante($donanteId);
            return response()->json([
                'success' => true,
                'data' => $informacionContactos
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
