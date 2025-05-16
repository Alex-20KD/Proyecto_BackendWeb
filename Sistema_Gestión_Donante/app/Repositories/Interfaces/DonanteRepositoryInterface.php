<?php

namespace App\Repositories\Interfaces;

interface DonanteRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail($email);
    public function findByDocumento($tipoDocumento, $numeroDocumento);
    public function getActiveDonantes();
}
