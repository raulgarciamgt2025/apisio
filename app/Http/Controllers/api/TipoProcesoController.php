<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\TipoProcesoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TipoProcesoController extends Controller
{
    private TipoProcesoRepositoryInterface $tipoProcesoRepository;

    public function __construct(TipoProcesoRepositoryInterface $tipoProcesoRepository)
    {
        $this->tipoProcesoRepository = $tipoProcesoRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->tipoProcesoRepository->all());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->tipoProcesoRepository->find($id));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:75',
            'estado' => 'required|string|in:SI,NO',
            'id_empresa' => 'required|exists:empresas,id'
        ]);

        $tipoProceso = $this->tipoProcesoRepository->create($data);

        return response()->json($tipoProceso, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'descripcion' => 'sometimes|string|max:75',
            'estado' => 'sometimes|string|in:SI,NO',
            'id_empresa' => 'sometimes|exists:empresas,id'
        ]);

        return response()->json($this->tipoProcesoRepository->update($id, $data));
        
    }

    public function destroy($id): JsonResponse
    {
        $this->tipoProcesoRepository->delete($id);

        return response()->json(null, 204);

    }

    public function getByEstado($estado): JsonResponse
    {
        return response()->json($this->tipoProcesoRepository->getByEstado($estado));
    }

    public function getByEmpresa($id_empresa): JsonResponse
    {
        return response()->json($this->tipoProcesoRepository->getByEmpresa($id_empresa));
    }
}
