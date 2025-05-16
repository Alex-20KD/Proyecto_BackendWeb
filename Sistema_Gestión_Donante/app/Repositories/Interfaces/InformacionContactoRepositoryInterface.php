<?php

namespace App\Repositories\Interfaces;

interface InformacionContactoRepositoryInterface extends BaseRepositoryInterface
{
    public function findByDonante($donanteId);
}
