<?php

namespace App\Repositories;
use App\Interfaces\MenuRepositoryInterface;
use App\Models\Menu;
class MenuRepository implements MenuRepositoryInterface
{
    public function all()
    {
        return Menu::all();
    }

    public function getByIdModulo($id)
    {
     return Menu::where('id_modulo',$id)->all();   
    }

    public function find($id)
    {
        return Menu::findOrFail($id);
    }

    public function create(array $data)
    {
        return Menu::create($data);
    }

    public function update($id, array $data)
    {
        $post = Menu::findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = Menu::findOrFail($id);
        $post->delete();
        return true;
    }
}
