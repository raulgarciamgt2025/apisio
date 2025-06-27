<?php

namespace App\Repositories;
use App\Interfaces\ModuloRepositoryInterface;
use App\Models\Modulo;
class ModuloRepository implements ModuloRepositoryInterface
{
    public function all()
    {
        return Modulo::all();
    }

    public function find($id)
    {
        return Modulo::findOrFail($id);
    }

    public function create(array $data)
    {
        return Modulo::create($data);
    }

    public function update($id, array $data)
    {
        $post = Modulo::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Modulo::findOrFail($id);
        $post->delete();
        return true;
    }
}
