<?php

namespace App\Repositories;

use App\Interfaces\ProcesoRepositoryInterface;
use App\Models\Proceso;


class ProcesoRepository implements ProcesoRepositoryInterface
{
    public function all()
    {
        return Proceso::all();
    }

    public function find($id)
    {
        return Proceso::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return Proceso::where('id_empresa', $id)->get();
    }

    public function getByEstado($estado)
    {
        return Proceso::where('estado', $estado)->get();
    }

    public function create(array $data)
    {
        return Proceso::create($data);
    }

    public function update($id, array $data)
    {
        $post = Proceso::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Proceso::findOrFail($id);
        $post->delete();
        return true;
    }
}
