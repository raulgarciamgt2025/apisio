<?php

namespace App\Repositories;

use App\Interfaces\AreaRepositoryInterface;
use App\Models\Area;

class AreaRepository implements AreaRepositoryInterface
{
    public function all()
    {
        return Area::all();
    }

    public function find($id)
    {
        return Area::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return Area::where('id_empresa', $id)->get();
    }

    public function getByEstado($estado)
    {
        return Area::where('estado', $estado)->get();
    }

    public function create(array $data)
    {
        return Area::create($data);
    }

    public function update($id, array $data)
    {
        $post = Area::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Area::findOrFail($id);
        $post->delete();
        return true;
    }
}
