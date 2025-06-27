<?php

namespace App\Interfaces;
use App\Interfaces\GenericRepositoryInterface;

interface OpcionRepositoryInterface  extends GenericRepositoryInterface
{
 public function getByIdMenu($id);
}
