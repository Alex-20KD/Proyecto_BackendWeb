<?php

namespace App\Services;

use App\Repositories\Interfaces\DonanteRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DonanteService
{
    protected $donanteRepository;

    public function __construct(DonanteRepositoryInterface $donanteRepository)
    {
        $this->donanteRepository = $donanteRepository;
    }

    public function getAllDonantes()
    {
        try {
            return $this->donanteRepository->all();
        } catch (Exception $e) {
            Log::error('Error al obtener todos los donantes: ' . $e->getMessage());
            throw new Exception('Error al obtener los donantes');
        }
    }

    public function getDonanteById($id)
    {
        try {
            $donante = $this->donanteRepository->find($id);
            if (!$donante) {
                throw new Exception('Donante no encontrado');
            }
            return $donante;
        } catch (Exception $e) {
            Log::error('Error al obtener donante por ID: ' . $e->getMessage());
            throw new Exception('Error al obtener el donante');
        }
    }

    public function createDonante(array $data)
    {
        try {
            // Validar datos
            $validator = Validator::make($data, [
                'nombre' => 'required|string|max:255',
                'correo' => 'required|email|unique:donantes,correo',
                'telefono' => 'required|string|max:20',
                'direccion' => 'required|string',
                'tipo_documento' => 'required|string|max:50',
                'numero_documento' => 'required|string|max:50|unique:donantes,numero_documento',
                'fecha_registro' => 'required|date',
                'estado' => 'sometimes|string|in:Activo,Inactivo,Suspendido',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            // Si no se proporciona estado, establecer por defecto a 'Activo'
            if (!isset($data['estado'])) {
                $data['estado'] = 'Activo';
            }

            return $this->donanteRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error al crear donante: ' . $e->getMessage());
            throw new Exception('Error al crear el donante: ' . $e->getMessage());
        }
    }

    public function updateDonante($id, array $data)
    {
        try {
            // Verificar si el donante existe
            $donante = $this->donanteRepository->find($id);
            if (!$donante) {
                throw new Exception('Donante no encontrado');
            }

            // Validar datos
            $validator = Validator::make($data, [
                'nombre' => 'sometimes|string|max:255',
                'correo' => 'sometimes|email|unique:donantes,correo,' . $id,
                'telefono' => 'sometimes|string|max:20',
                'direccion' => 'sometimes|string',
                'tipo_documento' => 'sometimes|string|max:50',
                'numero_documento' => 'sometimes|string|max:50|unique:donantes,numero_documento,' . $id,
                'fecha_registro' => 'sometimes|date',
                'estado' => 'sometimes|string|in:Activo,Inactivo,Suspendido',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            return $this->donanteRepository->update($id, $data);
        } catch (Exception $e) {
            Log::error('Error al actualizar donante: ' . $e->getMessage());
            throw new Exception('Error al actualizar el donante: ' . $e->getMessage());
        }
    }

    public function deleteDonante($id)
    {
        try {
            // Verificar si el donante existe
            $donante = $this->donanteRepository->find($id);
            if (!$donante) {
                throw new Exception('Donante no encontrado');
            }

            return $this->donanteRepository->delete($id);
        } catch (Exception $e) {
            Log::error('Error al eliminar donante: ' . $e->getMessage());
            throw new Exception('Error al eliminar el donante: ' . $e->getMessage());
        }
    }

    public function getDonanteByEmail($email)
    {
        try {
            return $this->donanteRepository->findByEmail($email);
        } catch (Exception $e) {
            Log::error('Error al buscar donante por email: ' . $e->getMessage());
            throw new Exception('Error al buscar el donante por email');
        }
    }

    public function getDonanteByDocumento($tipoDocumento, $numeroDocumento)
    {
        try {
            return $this->donanteRepository->findByDocumento($tipoDocumento, $numeroDocumento);
        } catch (Exception $e) {
            Log::error('Error al buscar donante por documento: ' . $e->getMessage());
            throw new Exception('Error al buscar el donante por documento');
        }
    }

    public function getActiveDonantes()
    {
        try {
            return $this->donanteRepository->getActiveDonantes();
        } catch (Exception $e) {
            Log::error('Error al obtener donantes activos: ' . $e->getMessage());
            throw new Exception('Error al obtener los donantes activos');
        }
    }
}
