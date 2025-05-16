<?php

namespace App\Repositories\Interfaces;

interface HistorialColaboracionRepositoryInterface extends BaseRepositoryInterface
{
    public function findByDonante($donanteId);
    public function findByTipoColaboracion($tipo);
}
