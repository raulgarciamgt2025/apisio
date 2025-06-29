<?php

namespace App\Repositories;
use App\Interfaces\RolusuarioRepositoryInterface;
use App\Models\Rolusuario;
use App\Models\Vw_rol_usuario;
class RolusuarioRepository implements RolusuarioRepositoryInterface
{
    public function all()
    {
        return Vw_rol_usuario::all();
    }

    public function find($id)
    {
        return Rolusuario::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return Vw_rol_usuario::where('id_empresa',$id)->get();   
    }


    public function getByRol($id)
    {
        return Vw_rol_usuario::where('id_rol',$id)->get();   
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
