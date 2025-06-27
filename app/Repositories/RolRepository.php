<?php

namespace App\Repositories;
use App\Interfaces\RolRepositoryInterface;
use App\Models\Rol;
class RolRepository implements RolRepositoryInterface
{
    public function all()
    {
        return Rol::all();
    }

    public function find($id)
    {
        return Rol::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return Rol::where('id_empresa',$id)->all();   
    }


    public function create(array $data)
    {
        return Rol::create($data);
    }

    public function update($id, array $data)
    {
        $post = Rol::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Rol::findOrFail($id);
        $post->delete();
        return true;
    }
}
