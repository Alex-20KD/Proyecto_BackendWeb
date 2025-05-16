<?php

namespace App\Services;

use App\Repositories\Interfaces\InformacionContactoRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class InformacionContactoService
{
    protected $informacionContactoRepository;

    public function __construct(InformacionContactoRepositoryInterface $informacionContactoRepository)
    {
        $this->informacionContactoRepository = $informacionContactoRepository;
    }

    public function getAllInformacionContactos()
    {
        try {
            return $this->informacionContactoRepository->all();
        } catch (Exception $e) {
            Log::error('Error al obtener toda la información de contactos: ' . $e->getMessage());
            throw new Exception('Error al obtener la información de contactos');
        }
    }

    public function getInformacionContactoById($id)
    {
        try {
            $informacionContacto = $this->informacionContactoRepository->find($id);
            if (!$informacionContacto) {
                throw new Exception('Información de contacto no encontrada');
            }
            return $informacionContacto;
        } catch (Exception $e) {
            Log::error('Error al obtener información de contacto por ID: ' . $e->getMessage());
            throw new Exception('Error al obtener la información de contacto');
        }
    }

    public function createInformacionContacto(array $data)
    {
        try {
            // Validar datos
            $validator = Validator::make($data, [
                'donante_id' => 'required|exists:donantes,id',
                'nombre_contacto' => 'required|string|max:255',
                'telefono' => 'required|string|max:20',
                'relacion' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            return $this->informacionContactoRepository->create($data);
        } catch (Exception $e) {
            Log::error('Error al crear información de contacto: ' . $e->getMessage());
            throw new Exception('Error al crear la información de contacto: ' . $e->getMessage());
        }
    }

    public function updateInformacionContacto($id, array $data)
    {
        try {
            // Verificar si la información de contacto existe
            $informacionContacto = $this->informacionContactoRepository->find($id);
            if (!$informacionContacto) {
                throw new Exception('Información de contacto no encontrada');
            }

            // Validar datos
            $validator = Validator::make($data, [
                'donante_id' => 'sometimes|exists:donantes,id',
                'nombre_contacto' => 'sometimes|string|max:255',
                'telefono' => 'sometimes|string|max:20',
                'relacion' => 'sometimes|string|max:100',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->first());
            }

            return $this->informacionContactoRepository->update($id, $data);
        } catch (Exception $e) {
            Log::error('Error al actualizar información de contacto: ' . $e->getMessage());
            throw new Exception('Error al actualizar la información de contacto: ' . $e->getMessage());
        }
    }

    public function deleteInformacionContacto($id)
    {
        try {
            // Verificar si la información de contacto existe
            $informacionContacto = $this->informacionContactoRepository->find($id);
            if (!$informacionContacto) {
                throw new Exception('Información de contacto no encontrada');
            }

            return $this->informacionContactoRepository->delete($id);
        } catch (Exception $e) {
            Log::error('Error al eliminar información de contacto: ' . $e->getMessage());
            throw new Exception('Error al eliminar la información de contacto: ' . $e->getMessage());
        }
    }

    public function getInformacionContactoByDonante($donanteId)
    {
        try {
            return $this->informacionContactoRepository->findByDonante($donanteId);
        } catch (Exception $e) {
            Log::error('Error al obtener información de contacto por donante: ' . $e->getMessage());
            throw new Exception('Error al obtener la información de contacto por donante');
        }
    }
}
