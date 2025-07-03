<?php

namespace App\Repositories;

use App\Interfaces\PeriodoRepositoryInterface;
use App\Models\Periodo;

class PeriodoRepository implements PeriodoRepositoryInterface
{
    public function all()
    {
        return Periodo::all();
    }

    public function find($id)
    {
        return Periodo::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return Periodo::where('id_empresa', $id)->get();
    }

    public function getByEstado($estado)
    {
        return Periodo::where('estado', $estado)->get();
    }

    public function getPeriodoActivo($id_empresa = null)
    {
        $query = Periodo::where('estado', 'SI')
                        ->where('fecha_inicio', '<=', now())
                        ->where('fecha_fin', '>=', now());
        
        if ($id_empresa) {
            $query->where('id_empresa', $id_empresa);
        }
        
        return $query->first();
    }

    public function create(array $data)
    {
        return Periodo::create($data);
    }

    public function update($id, array $data)
    {
        $post = Periodo::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Periodo::findOrFail($id);
        $post->delete();
        return true;
    }
}
