<?php

namespace App\Interfaces;
use App\Interfaces\GenericRepositoryInterface;
interface MenuRepositoryInterface extends GenericRepositoryInterface
{
    public function getByIdModulo($id);
}
