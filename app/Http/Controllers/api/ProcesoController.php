<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProcesoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProcesoController extends Controller
{
    private ProcesoRepositoryInterface $procesoRepository;

    public function __construct(ProcesoRepositoryInterface $procesoRepository)
    {
        $this->procesoRepository = $procesoRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->procesoRepository->all());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->procesoRepository->find($id));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:75',
            'id_empresa' => 'required|exists:empresa,id_empresa'
        ]);


        

        $proceso = $this->procesoRepository->create($data);

        return response()->json($proceso, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:75',
            'id_empresa' => 'required|exists:empresa,id_empresa'
        ]);

        return response()->json($this->procesoRepository->update($id, $data));
    }

    public function destroy($id): JsonResponse
    {

        $this->procesoRepository->delete($id);

        return response()->json(null, 204);
    }

    public function getByEstado($estado): JsonResponse
    {
        return response()->json($this->procesoRepository->getByEstado($estado));
    }

    public function getByEmpresa($id_empresa): JsonResponse
    {
        return response()->json($this->procesoRepository->getByEmpresa($id_empresa));
    }

    public function getProcesoActivo(Request $request): JsonResponse
    {
        $id_empresa = $request->query('id_empresa');
        $proceso = $this->procesoRepository->getProcesoActivo($id_empresa);

        if (!$proceso) {
            return response()->json([
                'message' => 'No hay proceso activo en este momento'
            ], 404);
        }

        return response()->json($proceso);
    }
}
