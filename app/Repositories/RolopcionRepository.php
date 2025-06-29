<?php

namespace App\Repositories;
use App\Interfaces\RolopcionRepositoryInterface;
use App\Models\Rolopcion;
use App\Models\Vw_rol_opcion;
class RolopcionRepository implements RolopcionRepositoryInterface
{
    public function all()
    {
        return Vw_rol_opcion::all();
    }

    public function find($id)
    {
        return Rolopcion::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return Vw_rol_opcion::where('id_empresa',$id)->get();   
    }

    public function getByRol($id)
    {
        return Vw_rol_opcion::where('id_rol',$id)->get();   
    }

    public function create(array $data)
    {
        return Rolopcion::create($data);
    }

    public function update($id, array $data)
    {
        $post = Rolopcion::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Rolopcion::findOrFail($id);
        $post->delete();
        return true;
    }
}

