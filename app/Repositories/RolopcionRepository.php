<?php

namespace App\Repositories;
use App\Interfaces\RolopcionRepositoryInterface;
use App\Models\Rolopcion;
class RolopcionRepository implements RolopcionRepositoryInterface
{
    public function all()
    {
        return Rolopcion::all();
    }

    public function find($id)
    {
        return Rolopcion::findOrFail($id);
    }

    public function getByEmpresa($id)
    {
        return Rolopcion::where('id_empresa',$id)->all();   
    }

    public function getByRol($id)
    {
        return Rolopcion::where('id_rol',$id)->all();   
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
