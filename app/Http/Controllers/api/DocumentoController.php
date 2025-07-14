<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Interfaces\DocumentoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Documento;

class DocumentoController extends Controller
{
    private DocumentoRepositoryInterface $repository;

    public function __construct(DocumentoRepositoryInterface $repository)
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
            'id_configuracion' => 'required|integer|exists:periodo_area_proceso,id_configuracion',
            'descripcion' => 'required|string|max:150',
            'id_usuario_editor' => 'required|integer|exists:users,id',
            'id_usuario_responsable' => 'required|integer|exists:users,id',
            'estado' => 'required|string|in:E,F,O',
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
            'archivo' => 'nullable|string|max:255',
            'ruta' => 'nullable|string|max:500',
        ]);

        $data['id_usuario_grabo'] = Auth::id();
        $data['fecha_grabo'] = now();

        $documento = $this->repository->create($data);
        
        return response()->json($documento, 201);
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
            'id_configuracion' => 'sometimes|required|integer|exists:periodo_area_proceso,id_configuracion',
            'descripcion' => 'sometimes|required|string|max:150',
            'id_usuario_editor' => 'sometimes|required|integer|exists:users,id',
            'id_usuario_responsable' => 'sometimes|required|integer|exists:users,id',
            'estado' => 'sometimes|required|string|in:E,F,O',
            'id_empresa' => 'sometimes|required|integer|exists:empresa,id_empresa',
            'archivo' => 'sometimes|nullable|string|max:255',
            'ruta' => 'sometimes|nullable|string|max:500',
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
     * Get documentos by configuracion
     */
    public function getByConfiguracion(int $idConfiguracion): JsonResponse
    {
        return response()->json($this->repository->getByConfiguracion($idConfiguracion));
    }

    /**
     * Get documentos by empresa
     */
    public function getByEmpresa(int $idEmpresa): JsonResponse
    {
        return response()->json($this->repository->getByEmpresa($idEmpresa));
    }

    /**
     * Get documentos by estado
     */
    public function getByEstado(string $estado): JsonResponse
    {
        // Validate estado parameter
        if (!in_array($estado, [Documento::ESTADO_ELABORACION, Documento::ESTADO_FINALIZADO, Documento::ESTADO_OBSOLETO])) {
            return response()->json(['error' => 'Invalid estado parameter'], 400);
        }

        return response()->json($this->repository->getByEstado($estado));
    }

    /**
     * Get documentos by usuario grabo
     */
    public function getByUsuarioGrabo(int $idUsuario): JsonResponse
    {
        return response()->json($this->repository->getByUsuarioGrabo($idUsuario));
    }

    /**
     * Get documentos by usuario editor
     */
    public function getByUsuarioEditor(int $idUsuario): JsonResponse
    {
        return response()->json($this->repository->getByUsuarioEditor($idUsuario));
    }

    /**
     * Get documentos by usuario responsable
     */
    public function getByUsuarioResponsable(int $idUsuario): JsonResponse
    {
        return response()->json($this->repository->getByUsuarioResponsable($idUsuario));
    }

    /**
     * Search documentos by description
     */
    public function searchByDescription(Request $request): JsonResponse
    {
        $request->validate([
            'description' => 'required|string|min:3'
        ]);

        return response()->json($this->repository->searchByDescription($request->description));
    }

    /**
     * Get documentos by date range
     */
    public function getByDateRange(Request $request): JsonResponse
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        return response()->json($this->repository->getByDateRange($request->start_date, $request->end_date));
    }

    /**
     * Get documentos by periodo, area, and proceso
     */
    public function getByPeriodoAreaProceso(int $idPeriodo, int $idArea, int $idProceso): JsonResponse
    {
        return response()->json($this->repository->getByPeriodoAreaProceso($idPeriodo, $idArea, $idProceso));
    }

    /**
     * Get documentos with detailed information including related data
     */
    public function getDocumentosWithDetails(Request $request): JsonResponse
    {
        $request->validate([
            'id_periodo' => 'sometimes|integer',
            'id_area' => 'sometimes|integer',
            'id_proceso' => 'sometimes|integer',
        ]);

        $idPeriodo = $request->query('id_periodo');
        $idArea = $request->query('id_area');
        $idProceso = $request->query('id_proceso');

        return response()->json($this->repository->getDocumentosWithDetails($idPeriodo, $idArea, $idProceso));
    }

    /**
     * Save image from base64 string
     */
    public function saveImage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'base64_string' => 'required|string',
            'id_documento' => 'required|integer|exists:documentos,id_documento',
        ]);

        $result = $this->repository->saveImage($data['base64_string'], $data['id_documento']);
        
        if ($result['success']) {
            return response()->json($result, 200);
        } else {
            return response()->json($result, 400);
        }
    }

    /**
     * Load image as base64 string
     */
    public function loadImage(int $idDocumento): JsonResponse
    {
        $result = $this->repository->loadImage($idDocumento);
        
        if ($result['success']) {
            return response()->json($result, 200);
        } else {
            return response()->json($result, 404);
        }
    }

    /**
     * Delete image file
     */
    public function deleteImage(int $idDocumento): JsonResponse
    {
        $result = $this->repository->deleteImage($idDocumento);
        
        if ($result['success']) {
            return response()->json($result, 200);
        } else {
            return response()->json($result, 400);
        }
    }
}
