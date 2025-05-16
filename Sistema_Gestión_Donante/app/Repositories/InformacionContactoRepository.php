<?php

namespace App\Repositories;

use App\Models\InformacionContacto;
use App\Repositories\Interfaces\InformacionContactoRepositoryInterface;

class InformacionContactoRepository extends BaseRepository implements InformacionContactoRepositoryInterface
{
    public function __construct(InformacionContacto $model)
    {
        parent::__construct($model);
    }

    public function findByDonante($donanteId)
    {
        return $this->model->where('donante_id', $donanteId)->get();
    }
}
