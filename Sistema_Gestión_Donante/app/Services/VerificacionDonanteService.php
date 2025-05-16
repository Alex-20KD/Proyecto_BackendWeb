<?php

namespace App\Services;

use App\Repositories\Interfaces\VerificacionDonanteRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VerificacionDonanteService
{
    protected $verificacionDonanteRepository;

    public function __construct(VerificacionDonanteRepositoryInterface $verificacionDonanteRepository)
    {
        $this->verificacionDonanteRepository = $verificacionDonanteRepository;
    }

    public function getAllVerificacionesDonantes()
    {
        try {
            return $this->verificacionDonanteRepository->all();
        } catch (Exception $e) {
            Log::error('Error al obtener todas las verificaciones de donantes: ' . $e->getMessage());
            throw new Exception('Error al obtener las verificaciones de donantes');
        }
    }

    public function getVerificacionDonanteById($id)
    {
        try {
            $verificacionDonante = $this->verificacionDonanteRepository->find($id);
            if (!$verificacionDonante) {
                throw new Exception('Verificación de donante no encontrada');
            }
            return $verificacionDonante;
        } catch (Exception $e) {
            Log::error('Error al obtener verificación de donante por ID: ' . $e->getMessage());
            throw new Exception('Error al obtener la verificación de donante');
        }
    }

    public function createVerificacionDonante(array $data)
    {
        try {
            // Validar datos
            $validator = Validator::make($data, [
                'donante_id' => 'required|exists:donantes,id',
                'fecha_verificacion' => 'required|date',
                'resultado' => 'required|string|in:Aprobado,Observación,Rechazado',
                'observaciones' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            return $this->verificacionDonanteRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error al crear verificación de donante: ' . $e->getMessage());
            throw new Exception('Error al crear la verificación de donante: ' . $e->getMessage());
        }
    }

    public function updateVerificacionDonante($id, array $data)
    {
        try {
            // Verificar si la verificación de donante existe
            $verificacionDonante = $this->verificacionDonanteRepository->find($id);
            if (!$verificacionDonante) {
                throw new Exception('Verificación de donante no encontrada');
            }

            // Validar datos
            $validator = Validator::make($data, [
                'donante_id' => 'sometimes|exists:donantes,id',
                'fecha_verificacion' => 'sometimes|date',
                'resultado' => 'sometimes|string|in:Aprobado,Observación,Rechazado',
                'observaciones' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            return $this->verificacionDonanteRepository->update($id, $data);
        } catch (Exception $e) {
            Log::error('Error al actualizar verificación de donante: ' . $e->getMessage());
            throw new Exception('Error al actualizar la verificación de donante: ' . $e->getMessage());
        }
    }

    public function deleteVerificacionDonante($id)
    {
        try {
            // Verificar si la verificación de donante existe
            $verificacionDonante = $this->verificacionDonanteRepository->find($id);
            if (!$verificacionDonante) {
                throw new Exception('Verificación de donante no encontrada');
            }

            return $this->verificacionDonanteRepository->delete($id);
        } catch (Exception $e) {
            Log::error('Error al eliminar verificación de donante: ' . $e->getMessage());
            throw new Exception('Error al eliminar la verificación de donante: ' . $e->getMessage());
        }
    }

    public function getVerificacionDonanteByDonante($donanteId)
    {
        try {
            return $this->verificacionDonanteRepository->findByDonante($donanteId);
        } catch (Exception $e) {
            Log::error('Error al obtener verificación de donante por donante: ' . $e->getMessage());
            throw new Exception('Error al obtener la verificación de donante por donante');
        }
    }

    public function getVerificacionDonanteByResultado($resultado)
    {
        try {
            return $this->verificacionDonanteRepository->findByResultado($resultado);
        } catch (Exception $e) {
            Log::error('Error al obtener verificación de donante por resultado: ' . $e->getMessage());
            throw new Exception('Error al obtener la verificación de donante por resultado');
        }
    }
}
