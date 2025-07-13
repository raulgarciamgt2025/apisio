<?php

namespace App\Repositories;

use App\Interfaces\PeriodoAreaProcesoRepositoryInterface;
use App\Models\PeriodoAreaProceso;
use Illuminate\Database\Eloquent\Collection;

class PeriodoAreaProcesoRepository implements PeriodoAreaProcesoRepositoryInterface
{
    protected $model;

    public function __construct(PeriodoAreaProceso $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->update($data);
        }
        return false;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    public function getByPeriodo(int $idPeriodo): Collection
    {
        return $this->model->where('id_periodo', $idPeriodo)->get();
    }

    public function getByArea(int $idArea): Collection
    {
        return $this->model->where('id_area', $idArea)->get();
    }

    public function getByProceso(int $idProceso): Collection
    {
        return $this->model->where('id_proceso', $idProceso)->get();
    }

    public function getByEmpresa(int $idEmpresa): Collection
    {
        return $this->model->where('id_empresa', $idEmpresa)->get();
    }

    public function getByUsuarioAsigno(int $idUsuario): Collection
    {
        return $this->model->where('id_usuario_asigno', $idUsuario)->get();
    }

    public function getAllWithRelations(): Collection
    {
        return $this->model->with([
            'empresa',
            'periodo',
            'area',
            'proceso',
            'usuarioAsigno'
        ])->get();
    }

    public function existsConfiguration(int $idPeriodo, int $idArea, int $idProceso, int $idEmpresa): bool
    {
        return $this->model
            ->where('id_periodo', $idPeriodo)
            ->where('id_area', $idArea)
            ->where('id_proceso', $idProceso)
            ->where('id_empresa', $idEmpresa)
            ->exists();
    }

    public function getByUniqueConfiguration(int $idPeriodo, int $idArea, int $idProceso, int $idEmpresa): ?PeriodoAreaProceso
    {
        return $this->model
            ->where('id_periodo', $idPeriodo)
            ->where('id_area', $idArea)
            ->where('id_proceso', $idProceso)
            ->where('id_empresa', $idEmpresa)
            ->first();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function findBy(string $field, $value): Collection
    {
        return $this->model->where($field, $value)->get();
    }

    public function findOneBy(string $field, $value): ?PeriodoAreaProceso
    {
        return $this->model->where($field, $value)->first();
    }
}
