<?php

namespace App\Repositories;
use App\Interfaces\OpcionRepositoryInterface;
use App\Models\Opcion;
class OpcionRepository implements OpcionRepositoryInterface
{
    public function all()
    {
        return Opcion::all();
    }
    public function getByIdMenu($id)
    {
     return Opcion::where('id_menu',$id)->get();   
    }

    public function find($id)
    {
        return Opcion::findOrFail($id);
    }

    public function create(array $data)
    {
        return Opcion::create($data);
    }

    public function update($id, array $data)
    {
        $post = Opcion::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Opcion::findOrFail($id);
        $post->delete();
        return true;
    }
}
