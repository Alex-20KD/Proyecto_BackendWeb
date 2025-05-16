<?php

namespace App\Repositories;

use App\Models\HistorialColaboracion;
use App\Repositories\Interfaces\HistorialColaboracionRepositoryInterface;

class HistorialColaboracionRepository extends BaseRepository implements HistorialColaboracionRepositoryInterface
{
    public function __construct(HistorialColaboracion $model)
    {
        parent::__construct($model);
    }

    public function findByDonante($donanteId)
    {
        return $this->model->where('donante_id', $donanteId)->get();
    }

    public function findByTipoColaboracion($tipo)
    {
        return $this->model->where('tipo_colaboracion', $tipo)->get();
    }
}
