<?php

namespace App\Repositories;

use App\Models\VerificacionDonante;
use App\Repositories\Interfaces\VerificacionDonanteRepositoryInterface;

class VerificacionDonanteRepository extends BaseRepository implements VerificacionDonanteRepositoryInterface
{
    public function __construct(VerificacionDonante $model)
    {
        parent::__construct($model);
    }

    public function findByDonante($donanteId)
    {
        return $this->model->where('donante_id', $donanteId)->get();
    }

    public function findByResultado($resultado)
    {
        return $this->model->where('resultado', $resultado)->get();
    }
}
