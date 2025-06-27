<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\RolRepositoryInterface;

class RolController extends Controller
{
    protected $rolRepo;
    public function __construct(RolRepositoryInterface $rolRepo)
    {
        $this->rolRepo = $rolRepo;
    }
    public function index()
    {
        return response()->json($this->rolRepo->all());
    }
    public function getByEmpresa($id)
    {
        return response()->json($this->rolRepo->getByEmpresa($id));
    }
    public function store(Request $request)
    {
        $post = $this->rolRepo->create($request->all());
        return response()->json($post, 201);
    }
    public function show($id)
    {
        return response()->json($this->rolRepo->find($id));
    }
    public function update(Request $request, $id)
    {
        return response()->json($this->rolRepo->update($id, $request->all()));
    }
    public function destroy($id)
    {
        $this->rolRepo->delete($id);
        return response()->json(null, 204);
    }

}
