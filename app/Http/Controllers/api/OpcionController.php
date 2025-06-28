<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\OpcionRepositoryInterface;
use Illuminate\Http\Request;

class OpcionController extends Controller
{
    protected $opcionRepo;

    public function __construct(OpcionRepositoryInterface $OpcionRepo)
    {
        $this->opcionRepo = $OpcionRepo;
    }

    public function getByMenu($id)
    {
        return response()->json($this->opcionRepo->getByIdMenu($id));
    }

    public function index()
    {
        return response()->json($this->opcionRepo->all());
    }

    public function store(Request $request)
    {
        $post = $this->opcionRepo->create($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        return response()->json($this->opcionRepo->find($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->opcionRepo->update($id, $request->all()));
    }

    public function destroy($id)
    {
        $this->opcionRepo->delete($id);
        return response()->json(null, 204);
    }
}
