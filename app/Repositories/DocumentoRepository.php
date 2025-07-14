<?php

namespace App\Repositories;

use App\Interfaces\DocumentoRepositoryInterface;
use App\Models\Documento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DocumentoRepository implements DocumentoRepositoryInterface
{
    protected $model;

    public function __construct(Documento $model)
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

    public function getByConfiguracion(int $idConfiguracion): Collection
    {
        return $this->model->byConfiguracion($idConfiguracion)->get();
    }

    public function getByEmpresa(int $idEmpresa): Collection
    {
        return $this->model->byEmpresa($idEmpresa)->get();
    }

    public function getByEstado(string $estado): Collection
    {
        return $this->model->byEstado($estado)->get();
    }

    public function getByUsuarioGrabo(int $idUsuario): Collection
    {
        return $this->model->where('id_usuario_grabo', $idUsuario)->get();
    }

    public function getByUsuarioEditor(int $idUsuario): Collection
    {
        return $this->model->where('id_usuario_editor', $idUsuario)->get();
    }

    public function getByUsuarioResponsable(int $idUsuario): Collection
    {
        return $this->model->where('id_usuario_responsable', $idUsuario)->get();
    }

    public function getAllWithRelations(): Collection
    {
        return $this->model->with([
            'configuracion',
            'empresa',
            'usuarioGrabo',
            'usuarioEditor',
            'usuarioResponsable'
        ])->get();
    }

    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->model
            ->whereBetween('fecha_grabo', [$startDate, $endDate])
            ->get();
    }

    public function searchByDescription(string $description): Collection
    {
        return $this->model
            ->where('descripcion', 'LIKE', '%' . $description . '%')
            ->get();
    }

    public function getByPeriodoAreaProceso(int $idPeriodo, int $idArea, int $idProceso): Collection
    {
        return $this->model
            ->whereHas('configuracion', function ($query) use ($idPeriodo, $idArea, $idProceso) {
                $query->where('id_periodo', $idPeriodo)
                      ->where('id_area', $idArea)
                      ->where('id_proceso', $idProceso);
            })
            ->get();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function findBy(string $field, $value): Collection
    {
        return $this->model->where($field, $value)->get();
    }

    public function findOneBy(string $field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    public function getDocumentosWithDetails(?int $idPeriodo = null, ?int $idArea = null, ?int $idProceso = null): \Illuminate\Support\Collection
    {
        $query = DB::table('documentos as a')
            ->select([
                'a.id_documento',
                'a.id_configuracion',
                'b.id_periodo',
                'c.label as periodo',
                'b.id_area',
                'd.descripcion as area',
                'b.id_proceso',
                'e.descripcion as proceso',
                'a.fecha_grabo',
                'a.id_usuario_grabo',
                'f.name as usuario_grabo',
                'a.descripcion',
                'a.id_usuario_editor',
                'g.name as usuario_editor',
                'a.id_usuario_responsable',
                'h.name as usuario_responsable',
                'a.estado',
                'a.id_empresa',
                'a.archivo',
                'a.ruta'
            ])
            ->join('periodo_area_proceso as b', 'a.id_configuracion', '=', 'b.id_configuracion')
            ->join('periodo as c', 'b.id_periodo', '=', 'c.id_periodo')
            ->join('area as d', 'b.id_area', '=', 'd.id_area')
            ->join('proceso as e', 'b.id_proceso', '=', 'e.id_proceso')
            ->join('users as f', 'a.id_usuario_grabo', '=', 'f.id')
            ->join('users as g', 'a.id_usuario_editor', '=', 'g.id')
            ->join('users as h', 'a.id_usuario_responsable', '=', 'h.id');

        // Apply filters if provided
        if ($idPeriodo !== null) {
            $query->where('b.id_periodo', $idPeriodo);
        }

        if ($idArea !== null) {
            $query->where('b.id_area', $idArea);
        }

        if ($idProceso !== null) {
            $query->where('b.id_proceso', $idProceso);
        }

        return $query->get();
    }
}
