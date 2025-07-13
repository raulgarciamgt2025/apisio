<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Interfaces\PeriodoAreaProcesoRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PeriodoAreaProcesoController extends Controller
{
    private PeriodoAreaProcesoRepositoryInterface $repository;

    public function __construct(PeriodoAreaProcesoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json($this->repository->getAllWithRelations());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id_periodo' => 'required|integer|exists:periodo,id_periodo',
            'id_area' => 'required|integer|exists:area,id_area',
            'id_proceso' => 'required|integer|exists:proceso,id_proceso',
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
        ]);

        // Check if configuration already exists
        if ($this->repository->existsConfiguration(
            $data['id_periodo'],
            $data['id_area'],
            $data['id_proceso'],
            $data['id_empresa']
        )) {
            return response()->json(['error' => 'Esta configuración ya existe'], 409);
        }

        $data['id_usuario_asigno'] = Auth::id();
        $data['fecha_asigno'] = now();

        $configuracion = $this->repository->create($data);
        
        return response()->json($configuracion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json($this->repository->find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $data = $request->validate([
            'id_periodo' => 'sometimes|required|integer|exists:periodo,id_periodo',
            'id_area' => 'sometimes|required|integer|exists:area,id_area',
            'id_proceso' => 'sometimes|required|integer|exists:proceso,id_proceso',
            'id_empresa' => 'sometimes|required|integer|exists:empresa,id_empresa',
        ]);

        return response()->json($this->repository->update($id, $data));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->repository->delete($id);
        
        return response()->json(null, 204);
    }

    /**
     * Get configurations by periodo
     */
    public function getByPeriodo(int $idPeriodo): JsonResponse
    {
        return response()->json($this->repository->getByPeriodo($idPeriodo));
    }

    /**
     * Get configurations by area
     */
    public function getByArea(int $idArea): JsonResponse
    {
        return response()->json($this->repository->getByArea($idArea));
    }

    /**
     * Get configurations by proceso
     */
    public function getByProceso(int $idProceso): JsonResponse
    {
        return response()->json($this->repository->getByProceso($idProceso));
    }

    /**
     * Get configurations by empresa
     */
    public function getByEmpresa(int $idEmpresa): JsonResponse
    {
        return response()->json($this->repository->getByEmpresa($idEmpresa));
    }
}
