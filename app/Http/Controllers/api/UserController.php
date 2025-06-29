<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        return response()->json($this->repo->all());
    }

    public function store(Request $request)
    {
        $post = $this->repo->create($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        return response()->json($this->repo->find($id));
    }
    public function updatePassword(Request $request, $id)
    {
        return response()->json($this->repo->updatePassword($id, $request->all()));
    }
    public function update(Request $request, $id)
    {
        return response()->json($this->repo->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return response()->json(null, 204);
    }
}
