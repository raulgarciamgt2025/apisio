<?php

namespace App\Interfaces;
use App\Interfaces\GenericRepositoryInterface;
interface UserRepositoryInterface extends GenericRepositoryInterface
{
     public function findbyEmail($email);
}
