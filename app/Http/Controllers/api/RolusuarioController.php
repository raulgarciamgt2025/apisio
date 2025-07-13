<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\RolusuarioRepositoryInterface;

class RolusuarioController extends Controller
{
    protected $Repo;
    public function __construct(RolusuarioRepositoryInterface $Repo)
    {
        $this->Repo = $Repo;
    }
    public function index()
    {
        return response()->json($this->Repo->all());
    }
    public function getByEmpresa($id)
    {
        return response()->json($this->Repo->getByEmpresa($id));
    }
    public function getByRol($id)
    {
        return response()->json($this->Repo->getByRol($id));
    }
    public function store(Request $request)
    {
        $post = $this->Repo->create($request->all());
        return response()->json($post, 201);
    }
    public function show($id)
    {
        return response()->json($this->Repo->find($id));
    }
    public function update(Request $request, $id)
    {
        return response()->json($this->Repo->update($id, $request->all()));
    }
    public function destroy($id)
    {
        $this->Repo->delete($id);
        return response()->json(null, 204);
    }
}
