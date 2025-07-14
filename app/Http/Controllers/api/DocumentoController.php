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
            'archivo_final' => 'nullable|string|max:255',
            'ruta_final' => 'nullable|string|max:500',
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
            'archivo_final' => 'sometimes|nullable|string|max:255',
            'ruta_final' => 'sometimes|nullable|string|max:500',
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
     * Get documentos by empresa, periodo and usuario editor
     */
    public function getDocumentosByEmpresaPeriodoEditor(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
            'id_periodo' => 'required|integer|exists:periodo,id_periodo',
            'id_usuario_editor' => 'required|integer|exists:users,id',
        ]);

        return response()->json($this->repository->getDocumentosByEmpresaPeriodoEditor(
            $data['id_empresa'], 
            $data['id_periodo'], 
            $data['id_usuario_editor']
        ));
    }

    /**
     * Save image from base64 string
     */
    public function saveImage(Request $request): JsonResponse
    {
        $data = $request->validate([
            'base64_string' => 'required|string',
            'id_documento' => 'required|integer|exists:documentos,id_documento',
            'id_usuario_cargo' => 'required|integer|exists:users,id',
        ]);

        $result = $this->repository->saveImage($data['base64_string'], $data['id_documento'], $data['id_usuario_cargo']);
        
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

    /**
     * Finalize document - update estado to 'F' and optionally upload final PDF
     */
    public function finalizeDocument(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id_documento' => 'required|integer|exists:documentos,id_documento',
            'base64_string' => 'nullable|string', // Optional: upload new final PDF
            'id_usuario_cargo' => 'required|integer|exists:users,id',
        ]);

        // First check if document has archivo and ruta (as per your requirement)
        $documento = $this->repository->find($data['id_documento']);
        if (!$documento) {
            return response()->json([
                'success' => false,
                'message' => 'Documento no encontrado'
            ], 404);
        }

        if (empty($documento->archivo) || empty($documento->ruta)) {
            return response()->json([
                'success' => false,
                'message' => 'El documento debe tener un archivo cargado antes de finalizar'
            ], 400);
        }

        // If a new PDF is provided, save it as final file
        if (!empty($data['base64_string'])) {
            $result = $this->repository->saveFinalImage(
                $data['base64_string'], 
                $data['id_documento'], 
                $data['id_usuario_cargo']
            );
            
            if (!$result['success']) {
                return response()->json($result, 400);
            }
        }

        // Update document estado to 'F' (Finalizado)
        $updateResult = $this->repository->update($data['id_documento'], [
            'estado' => Documento::ESTADO_FINALIZADO
        ]);

        if ($updateResult) {
            return response()->json([
                'success' => true,
                'message' => 'Documento finalizado exitosamente',
                'data' => $this->repository->find($data['id_documento'])
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al finalizar el documento'
            ], 400);
        }
    }

    /**
     * Save final image from base64 string
     */
    public function saveImageFinal(Request $request): JsonResponse
    {
        $data = $request->validate([
            'base64_string' => 'required|string',
            'id_documento' => 'required|integer|exists:documentos,id_documento',
            'id_usuario_cargo_archivo_final' => 'required|integer|exists:users,id',
        ]);

        $result = $this->repository->saveFinalImage(
            $data['base64_string'], 
            $data['id_documento'], 
            $data['id_usuario_cargo_archivo_final']
        );
        
        if ($result['success']) {
            // Update document estado to 'F' (Finalizado) when final file is uploaded
            $this->repository->update($data['id_documento'], [
                'estado' => Documento::ESTADO_FINALIZADO
            ]);
            
            return response()->json($result, 200);
        } else {
            return response()->json($result, 400);
        }
    }

    /**
     * Load final image as base64 string
     */
    public function loadImageFinal(int $idDocumento): JsonResponse
    {
        $result = $this->repository->loadFinalImage($idDocumento);
        
        if ($result['success']) {
            return response()->json($result, 200);
        } else {
            return response()->json($result, 404);
        }
    }

    /**
     * Delete final image file
     */
    public function deleteImageFinal(int $idDocumento): JsonResponse
    {
        $result = $this->repository->deleteFinalImage($idDocumento);
        
        if ($result['success']) {
            return response()->json($result, 200);
        } else {
            return response()->json($result, 400);
        }
    }

    /**
     * Archive document files and reset to elaboration state
     */
    public function archiveDocument(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id_documento' => 'required|integer|exists:documentos,id_documento',
            'id_usuario_archivo' => 'required|integer|exists:users,id',
        ]);

        $result = $this->repository->archiveDocument(
            $data['id_usuario_archivo'], 
            $data['id_documento']
        );
        
        if ($result['success']) {
            return response()->json($result, 200);
        } else {
            return response()->json($result, 400);
        }
    }
}
