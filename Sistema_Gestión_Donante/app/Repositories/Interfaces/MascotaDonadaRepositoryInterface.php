<?php

namespace App\Repositories\Interfaces;

interface MascotaDonadaRepositoryInterface extends BaseRepositoryInterface
{
    public function findByDonante($donanteId);
    public function findByEstado($estado);
}
