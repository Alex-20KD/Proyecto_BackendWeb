<?php

namespace App\Services;

use App\Repositories\Interfaces\MascotaDonadaRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MascotaDonadaService
{
    protected $mascotaDonadaRepository;

    public function __construct(MascotaDonadaRepositoryInterface $mascotaDonadaRepository)
    {
        $this->mascotaDonadaRepository = $mascotaDonadaRepository;
    }

    public function getAllMascotasDonadas()
    {
        try {
            return $this->mascotaDonadaRepository->all();
        } catch (Exception $e) {
            Log::error('Error al obtener todas las mascotas donadas: ' . $e->getMessage());
            throw new Exception('Error al obtener las mascotas donadas');
        }
    }

    public function getMascotaDonadaById($id)
    {
        try {
            $mascotaDonada = $this->mascotaDonadaRepository->find($id);
            if (!$mascotaDonada) {
                throw new Exception('Mascota donada no encontrada');
            }
            return $mascotaDonada;
        } catch (Exception $e) {
            Log::error('Error al obtener mascota donada por ID: ' . $e->getMessage());
            throw new Exception('Error al obtener la mascota donada');
        }
    }

    public function createMascotaDonada(array $data)
    {
        try {
            // Validar datos
            $validator = Validator::make($data, [
                'donante_id' => 'required|exists:donantes,id',
                'mascota_id' => 'required|integer',
                'fecha_donacion' => 'required|date',
                'motivo_donacion' => 'required|string',
                'estado_revision' => 'sometimes|string|in:Pendiente,Aceptada,Rechazada',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            // Si no se proporciona estado_revision, establecer por defecto a 'Pendiente'
            if (!isset($data['estado_revision'])) {
                $data['estado_revision'] = 'Pendiente';
            }

            return $this->mascotaDonadaRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error al crear mascota donada: ' . $e->getMessage());
            throw new Exception('Error al crear la mascota donada: ' . $e->getMessage());
        }
    }

    public function updateMascotaDonada($id, array $data)
    {
        try {
            // Verificar si la mascota donada existe
            $mascotaDonada = $this->mascotaDonadaRepository->find($id);
            if (!$mascotaDonada) {
                throw new Exception('Mascota donada no encontrada');
            }

            // Validar datos
            $validator = Validator::make($data, [
                'donante_id' => 'sometimes|exists:donantes,id',
                'mascota_id' => 'sometimes|integer',
                'fecha_donacion' => 'sometimes|date',
                'motivo_donacion' => 'sometimes|string',
                'estado_revision' => 'sometimes|string|in:Pendiente,Aceptada,Rechazada',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            return $this->mascotaDonadaRepository->update($id, $data);
        } catch (Exception $e) {
            Log::error('Error al actualizar mascota donada: ' . $e->getMessage());
            throw new Exception('Error al actualizar la mascota donada: ' . $e->getMessage());
        }
    }

    public function deleteMascotaDonada($id)
    {
        try {
            // Verificar si la mascota donada existe
            $mascotaDonada = $this->mascotaDonadaRepository->find($id);
            if (!$mascotaDonada) {
                throw new Exception('Mascota donada no encontrada');
            }

            return $this->mascotaDonadaRepository->delete($id);
        } catch (Exception $e) {
            Log::error('Error al eliminar mascota donada: ' . $e->getMessage());
            throw new Exception('Error al eliminar la mascota donada: ' . $e->getMessage());
        }
    }

    public function getMascotasDonadasByDonante($donanteId)
    {
        try {
            return $this->mascotaDonadaRepository->findByDonante($donanteId);
        } catch (Exception $e) {
            Log::error('Error al obtener mascotas donadas por donante: ' . $e->getMessage());
            throw new Exception('Error al obtener las mascotas donadas por donante');
        }
    }

    public function getMascotasDonadasByEstado($estado)
    {
        try {
            return $this->mascotaDonadaRepository->findByEstado($estado);
        } catch (Exception $e) {
            Log::error('Error al obtener mascotas donadas por estado: ' . $e->getMessage());
            throw new Exception('Error al obtener las mascotas donadas por estado');
        }
    }
}
