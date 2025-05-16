<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Sistema de Gestión de Donantes - API",
 *     version="1.0.0",
 *     description="API para el módulo de donantes del sistema de adopciones de animales",
 *     @OA\Contact(
 *         email="admin@sistema-adopciones.com"
 *     )
 * )
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor de desarrollo"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
