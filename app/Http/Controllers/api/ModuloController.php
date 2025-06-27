<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\ModuloRepositoryInterface;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    protected $moduloRepo;

    public function __construct(ModuloRepositoryInterface $ModRepo)
    {
        $this->moduloRepo = $ModRepo;
    }

    public function index()
    {
        return response()->json($this->moduloRepo->all());
    }

    public function store(Request $request)
    {
        $post = $this->moduloRepo->create($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        return response()->json($this->moduloRepo->find($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->moduloRepo->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->moduloRepo->delete($id);
        return response()->json(null, 204);
    }
}
