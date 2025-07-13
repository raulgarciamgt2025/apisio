<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Interfaces\PeriodoAreaProcesoRepositoryInterface;
use Illuminate\Support\Facades\Validator;
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
        try {
            $configuraciones = $this->repository->getAllWithRelations();
            return response()->json([
                'success' => true,
                'data' => $configuraciones
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las configuraciones: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_periodo' => 'required|integer|exists:periodo,id_periodo',
            'id_area' => 'required|integer|exists:area,id_area',
            'id_proceso' => 'required|integer|exists:proceso,id_proceso',
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Check if configuration already exists
            if ($this->repository->existsConfiguration(
                $request->id_periodo,
                $request->id_area,
                $request->id_proceso,
                $request->id_empresa
            )) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta configuración ya existe'
                ], 409);
            }

            $data = $request->all();
            $data['id_usuario_asigno'] = Auth::id();
            $data['fecha_asigno'] = now();

            $configuracion = $this->repository->create($data);
            
            return response()->json([
                'success' => true,
                'message' => 'Configuración creada exitosamente',
                'data' => $configuracion
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $configuracion = $this->repository->find($id);
            
            if (!$configuracion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Configuración no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $configuracion->load([
                    'empresa',
                    'periodo',
                    'area',
                    'proceso',
                    'usuarioAsigno'
                ])
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id_periodo' => 'sometimes|required|integer|exists:periodo,id_periodo',
            'id_area' => 'sometimes|required|integer|exists:area,id_area',
            'id_proceso' => 'sometimes|required|integer|exists:proceso,id_proceso',
            'id_empresa' => 'sometimes|required|integer|exists:empresa,id_empresa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de validación incorrectos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $configuracion = $this->repository->find($id);
            
            if (!$configuracion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Configuración no encontrada'
                ], 404);
            }

            $updated = $this->repository->update($id, $request->all());
            
            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' => 'Configuración actualizada exitosamente',
                    'data' => $this->repository->find($id)
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar la configuración'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $configuracion = $this->repository->find($id);
            
            if (!$configuracion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Configuración no encontrada'
                ], 404);
            }

            $deleted = $this->repository->delete($id);
            
            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Configuración eliminada exitosamente'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar la configuración'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la configuración: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get configurations by periodo
     */
    public function getByPeriodo(int $idPeriodo): JsonResponse
    {
        try {
            $configuraciones = $this->repository->getByPeriodo($idPeriodo);
            return response()->json([
                'success' => true,
                'data' => $configuraciones
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener configuraciones por periodo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get configurations by area
     */
    public function getByArea(int $idArea): JsonResponse
    {
        try {
            $configuraciones = $this->repository->getByArea($idArea);
            return response()->json([
                'success' => true,
                'data' => $configuraciones
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener configuraciones por área: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get configurations by proceso
     */
    public function getByProceso(int $idProceso): JsonResponse
    {
        try {
            $configuraciones = $this->repository->getByProceso($idProceso);
            return response()->json([
                'success' => true,
                'data' => $configuraciones
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener configuraciones por proceso: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get configurations by empresa
     */
    public function getByEmpresa(int $idEmpresa): JsonResponse
    {
        try {
            $configuraciones = $this->repository->getByEmpresa($idEmpresa);
            return response()->json([
                'success' => true,
                'data' => $configuraciones
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener configuraciones por empresa: ' . $e->getMessage()
            ], 500);
        }
    }
}
