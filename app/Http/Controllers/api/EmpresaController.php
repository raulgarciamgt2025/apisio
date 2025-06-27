<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\EmpresaRepositoryInterface;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    protected $empresaRepo;

    public function __construct(EmpresaRepositoryInterface $EmpRepo)
    {
        $this->empresaRepo = $EmpRepo;
    }

    public function index()
    {
        return response()->json($this->empresaRepo->all());
    }

    public function store(Request $request)
    {
        $post = $this->empresaRepo->create($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        return response()->json($this->empresaRepo->find($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->empresaRepo->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->empresaRepo->delete($id);
        return response()->json(null, 204);
    }
}
