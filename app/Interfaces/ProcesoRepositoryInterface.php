<?php

namespace App\Interfaces;

use App\Interfaces\GenericRepositoryInterface;

interface ProcesoRepositoryInterface extends GenericRepositoryInterface
{
    public function getByEstado($estado);
    public function getByEmpresa($id_empresa);
}
