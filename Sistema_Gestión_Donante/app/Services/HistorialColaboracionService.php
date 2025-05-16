<?php

namespace App\Services;

use App\Repositories\Interfaces\HistorialColaboracionRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HistorialColaboracionService
{
    protected $historialColaboracionRepository;

    public function __construct(HistorialColaboracionRepositoryInterface $historialColaboracionRepository)
    {
        $this->historialColaboracionRepository = $historialColaboracionRepository;
    }

    public function getAllHistorialColaboraciones()
    {
        try {
            return $this->historialColaboracionRepository->all();
        } catch (Exception $e) {
            Log::error('Error al obtener todo el historial de colaboraciones: ' . $e->getMessage());
            throw new Exception('Error al obtener el historial de colaboraciones');
        }
    }

    public function getHistorialColaboracionById($id)
    {
        try {
            $historialColaboracion = $this->historialColaboracionRepository->find($id);
            if (!$historialColaboracion) {
                throw new Exception('Historial de colaboración no encontrado');
            }
            return $historialColaboracion;
        } catch (Exception $e) {
            Log::error('Error al obtener historial de colaboración por ID: ' . $e->getMessage());
            throw new Exception('Error al obtener el historial de colaboración');
        }
    }

    public function createHistorialColaboracion(array $data)
    {
        try {
            // Validar datos
            $validator = Validator::make($data, [
                'donante_id' => 'required|exists:donantes,id',
                'tipo_colaboracion' => 'required|string|max:50',
                'descripcion' => 'required|string',
                'fecha_colaboracion' => 'required|date',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            return $this->historialColaboracionRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error al crear historial de colaboración: ' . $e->getMessage());
            throw new Exception('Error al crear el historial de colaboración: ' . $e->getMessage());
        }
    }

    public function updateHistorialColaboracion($id, array $data)
    {
        try {
            // Verificar si el historial de colaboración existe
            $historialColaboracion = $this->historialColaboracionRepository->find($id);
            if (!$historialColaboracion) {
                throw new Exception('Historial de colaboración no encontrado');
            }

            // Validar datos
            $validator = Validator::make($data, [
                'donante_id' => 'sometimes|exists:donantes,id',
                'tipo_colaboracion' => 'sometimes|string|max:50',
                'descripcion' => 'sometimes|string',
                'fecha_colaboracion' => 'sometimes|date',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            return $this->historialColaboracionRepository->update($id, $data);
        } catch (Exception $e) {
            Log::error('Error al actualizar historial de colaboración: ' . $e->getMessage());
            throw new Exception('Error al actualizar el historial de colaboración: ' . $e->getMessage());
        }
    }

    public function deleteHistorialColaboracion($id)
    {
        try {
            // Verificar si el historial de colaboración existe
            $historialColaboracion = $this->historialColaboracionRepository->find($id);
            if (!$historialColaboracion) {
                throw new Exception('Historial de colaboración no encontrado');
            }

            return $this->historialColaboracionRepository->delete($id);
        } catch (Exception $e) {
            Log::error('Error al eliminar historial de colaboración: ' . $e->getMessage());
            throw new Exception('Error al eliminar el historial de colaboración: ' . $e->getMessage());
        }
    }

    public function getHistorialColaboracionByDonante($donanteId)
    {
        try {
            return $this->historialColaboracionRepository->findByDonante($donanteId);
        } catch (Exception $e) {
            Log::error('Error al obtener historial de colaboración por donante: ' . $e->getMessage());
            throw new Exception('Error al obtener el historial de colaboración por donante');
        }
    }

    public function getHistorialColaboracionByTipo($tipo)
    {
        try {
            return $this->historialColaboracionRepository->findByTipoColaboracion($tipo);
        } catch (Exception $e) {
            Log::error('Error al obtener historial de colaboración por tipo: ' . $e->getMessage());
            throw new Exception('Error al obtener el historial de colaboración por tipo');
        }
    }
}
