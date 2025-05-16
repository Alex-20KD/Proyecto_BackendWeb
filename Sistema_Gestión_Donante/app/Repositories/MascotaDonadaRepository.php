<?php

namespace App\Repositories;

use App\Models\MascotaDonada;
use App\Repositories\Interfaces\MascotaDonadaRepositoryInterface;

class MascotaDonadaRepository extends BaseRepository implements MascotaDonadaRepositoryInterface
{
    public function __construct(MascotaDonada $model)
    {
        parent::__construct($model);
    }

    public function findByDonante($donanteId)
    {
        return $this->model->where('donante_id', $donanteId)->get();
    }

    public function findByEstado($estado)
    {
        return $this->model->where('estado_revision', $estado)->get();
    }
}
