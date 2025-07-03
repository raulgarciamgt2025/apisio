<?php

namespace App\Repositories;

use App\Interfaces\TipoProcesoRepositoryInterface;
use App\Models\TipoProceso;

class TipoProcesoRepository implements TipoProcesoRepositoryInterface
{
    public function all()
    {
        return TipoProceso::all();
    }

    public function find($id)
    {
        return TipoProceso::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return TipoProceso::where('id_empresa', $id)->get();
    }

    public function getByEstado($estado)
    {
        return TipoProceso::where('estado', $estado)->get();
    }

    public function create(array $data)
    {
        return TipoProceso::create($data);
    }

    public function update($id, array $data)
    {
        $post = TipoProceso::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = TipoProceso::findOrFail($id);
        $post->delete();
        return true;
    }
}
