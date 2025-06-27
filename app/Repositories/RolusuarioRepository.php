<?php

namespace App\Repositories;
use App\Interfaces\RolusuarioRepositoryInterface;
use App\Models\Rolusuario;
class RolusuarioRepository implements RolusuarioRepositoryInterface
{
    public function all()
    {
        return Rolusuario::all();
    }

    public function find($id)
    {
        return Rolusuario::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return Rolusuario::where('id_empresa',$id)->all();   
    }


    public function getByRol($id)
    {
        return Rolusuario::where('id_rol',$id)->all();   
    }

    public function create(array $data)
    {
        return Rolusuario::create($data);
    }

    public function update($id, array $data)
    {
        $post = Rolusuario::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Rolusuario::findOrFail($id);
        $post->delete();
        return true;
    }
}
