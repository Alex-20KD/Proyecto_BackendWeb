<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DonanteController;
use App\Http\Controllers\API\MascotaDonadaController;
use App\Http\Controllers\API\HistorialColaboracionController;
use App\Http\Controllers\API\InformacionContactoController;
use App\Http\Controllers\API\VerificacionDonanteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para Donantes
Route::apiResource('donantes', DonanteController::class);
Route::get('donantes/email/{email}', [DonanteController::class, 'findByEmail']);
Route::get('donantes/activos', [DonanteController::class, 'getActiveDonantes']);

// Rutas para Mascotas Donadas
Route::apiResource('mascotas-donadas', MascotaDonadaController::class);
Route::get('mascotas-donadas/donante/{donanteId}', [MascotaDonadaController::class, 'getByDonante']);
Route::get('mascotas-donadas/estado/{estado}', [MascotaDonadaController::class, 'getByEstado']);

// Rutas para Historial de Colaboraciones
Route::apiResource('historial-colaboraciones', HistorialColaboracionController::class);
Route::get('historial-colaboraciones/donante/{donanteId}', [HistorialColaboracionController::class, 'getByDonante']);
Route::get('historial-colaboraciones/tipo/{tipo}', [HistorialColaboracionController::class, 'getByTipo']);

// Rutas para Información de Contacto
Route::apiResource('informacion-contactos', InformacionContactoController::class);
Route::get('informacion-contactos/donante/{donanteId}', [InformacionContactoController::class, 'getByDonante']);

// Rutas para Verificación de Donantes
Route::apiResource('verificaciones-donantes', VerificacionDonanteController::class);
Route::get('verificaciones-donantes/donante/{donanteId}', [VerificacionDonanteController::class, 'getByDonante']);
Route::get('verificaciones-donantes/resultado/{resultado}', [VerificacionDonanteController::class, 'getByResultado']);
