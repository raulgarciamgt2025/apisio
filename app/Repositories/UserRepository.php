<?php

namespace App\Repositories;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }
    public function findbyEmail($email)
    {
     return User::where('email',$id)->all();   
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        $user = User::create([
            'name' => $data["name"],
            'email' => $data["email"],
            'password' => Hash::make($data["password"]),
        ]);
        return $user;
    }

    public function update($id, array $data)
    {
        $post = User::findOrFail($id);
        $post->name = $data["name"];
        $post->email = $data["email"];
        if ( $data["password"]!= "")
            $post->password = Hash::make($data["password"]);
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
