<?php

namespace App\Interfaces;

interface PeriodoRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getByEstado($estado);
    public function getByEmpresa($id_empresa);
    public function getPeriodoActivo($id_empresa = null);
}
