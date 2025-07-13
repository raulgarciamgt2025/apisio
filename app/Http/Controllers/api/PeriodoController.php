<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Interfaces\PeriodoRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PeriodoController extends Controller
{
    private PeriodoRepositoryInterface $periodoRepository;

    public function __construct(PeriodoRepositoryInterface $periodoRepository)
    {
        $this->periodoRepository = $periodoRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->periodoRepository->all());
    }

    public function show($id): JsonResponse
    {
        return response()->json($this->periodoRepository->find($id));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'label' => 'required|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'estado' => 'required|string|in:SI,NO',
            'id_empresa' => 'required|exists:empresa,id_empresa'
        ]);


        

        $periodo = $this->periodoRepository->create($data);

        return response()->json($periodo, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'label' => 'sometimes|string|max:50',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'sometimes|date',
            'estado' => 'sometimes|string|in:SI,NO',
            'id_empresa' => 'sometimes|exists:empresa,id_empresa'
        ]);

        return response()->json($this->periodoRepository->update($id, $data));
    }

    public function destroy($id): JsonResponse
    {

        $this->periodoRepository->delete($id);

        return response()->json(null, 204);
    }

    public function getByEstado($estado): JsonResponse
    {
        return response()->json($this->periodoRepository->getByEstado($estado));
    }

    public function getByEmpresa($id_empresa): JsonResponse
    {
        return response()->json($this->periodoRepository->getByEmpresa($id_empresa));
    }

    public function getPeriodoActivo(Request $request): JsonResponse
    {
        $id_empresa = $request->query('id_empresa');
        $periodo = $this->periodoRepository->getPeriodoActivo($id_empresa);
        
        if (!$periodo) {
            return response()->json([
                'message' => 'No hay período activo en este momento'
            ], 404);
        }

        return response()->json($periodo);
    }
}
