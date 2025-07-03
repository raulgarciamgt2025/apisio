<?php

namespace App\Interfaces;

use App\Interfaces\GenericRepositoryInterface;

interface PeriodoRepositoryInterface extends GenericRepositoryInterface
{
    public function getByEstado($estado);
    public function getByEmpresa($id_empresa);
    public function getPeriodoActivo($id_empresa = null);
}
