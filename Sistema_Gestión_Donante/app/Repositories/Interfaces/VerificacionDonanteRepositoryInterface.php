<?php

namespace App\Repositories\Interfaces;

interface VerificacionDonanteRepositoryInterface extends BaseRepositoryInterface
{
    public function findByDonante($donanteId);
    public function findByResultado($resultado);
}
