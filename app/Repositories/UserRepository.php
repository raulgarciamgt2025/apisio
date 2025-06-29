<?php

namespace App\Repositories;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }
    public function findbyEmail($email)
    {
     return User::where('email',$email)->get();   
    }

    public function find($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        $password_temporal = "123456789";
        $user = User::create([
            'name' => $data["name"],
            'email' => $data["email"],
            'password' => Hash::make($password_temporal),
        ]);
        return $user;
    }


    public function update($id, array $data)
    {
        
        $post = User::findOrFail($id);
        $post->name = $data["name"];
        $post->email = $data["email"];
        $post->save();
        return $post;
    }

    public function updatePassword($id, array $data)
    {
        
        $post = User::findOrFail($id);
        $post->password = Hash::make($data["password"]);
        $post->save();
        return $post;
    }

    public function delete($id)
    {
        $post = User::findOrFail($id);
        $post->delete();
        return true;
    }
}
