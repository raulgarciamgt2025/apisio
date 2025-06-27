<?php

namespace App\Repositories;
use App\Interfaces\EmpresaRepositoryInterface;
use App\Models\Empresa;

class EmpresaRepository implements EmpresaRepositoryInterface
{
    public function all()
    {
        return Empresa::all();
    }

    public function find($id)
    {
        return Empresa::findOrFail($id);
    }

    public function create(array $data)
    {
        return Empresa::create($data);
    }

    public function update($id, array $data)
    {
        $post = Empresa::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Empresa::findOrFail($id);
        $post->delete();
        return true;
    }
}
