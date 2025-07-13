<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\AreaRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AreaController extends Controller
{
    private AreaRepositoryInterface $areaRepository;

    public function __construct(AreaRepositoryInterface $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->areaRepository->all());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->areaRepository->find($id));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:75',
            'estado' => 'required|string|in:SI,NO',
            'id_empresa' => 'required|exists:empresa,id_empresa'
        ]);

        $area = $this->areaRepository->create($data);

        return response()->json($area, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'descripcion' => 'sometimes|string|max:75',
            'estado' => 'sometimes|string|in:SI,NO',
            'id_empresa' => 'sometimes|exists:empresa,id_empresa'
        ]);

        return response()->json($this->areaRepository->update($id, $data));
    }

    public function destroy($id): JsonResponse
    {
        $this->areaRepository->delete($id);

        return response()->json([
            'message' => 'Área eliminada exitosamente'
        ]);
    }

    public function getByEstado($estado): JsonResponse
    {
        return response()->json($this->areaRepository->getByEstado($estado));
    }

    public function getByEmpresa($id_empresa): JsonResponse
    {
        return response()->json($this->areaRepository->getByEmpresa($id_empresa));
    }
}
