<?php

namespace App\Repositories;

use App\Models\Donante;
use App\Repositories\Interfaces\DonanteRepositoryInterface;

class DonanteRepository extends BaseRepository implements DonanteRepositoryInterface
{
    public function __construct(Donante $model)
    {
        parent::__construct($model);
    }

    public function findByEmail($email)
    {
        return $this->model->where('correo', $email)->first();
    }

    public function findByDocumento($tipoDocumento, $numeroDocumento)
    {
        return $this->model->where('tipo_documento', $tipoDocumento)
                          ->where('numero_documento', $numeroDocumento)
                          ->first();
    }

    public function getActiveDonantes()
    {
        return $this->model->where('estado', 'Activo')->get();
    }
}
