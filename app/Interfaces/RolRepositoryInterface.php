<?php

namespace App\Interfaces;
use App\Interfaces\GenericRepositoryInterface;
interface RolRepositoryInterface extends GenericRepositoryInterface
{
    public function getByEmpresa($id);
}
