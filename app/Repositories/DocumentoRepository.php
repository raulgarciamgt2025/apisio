<?php

namespace App\Repositories;

use App\Interfaces\DocumentoRepositoryInterface;
use App\Models\Documento;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentoRepository implements DocumentoRepositoryInterface
{
    protected $model;

    public function __construct(Documento $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->update($data);
        }
        return false;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    public function getByConfiguracion(int $idConfiguracion): Collection
    {
        return $this->model->byConfiguracion($idConfiguracion)->get();
    }

    public function getByEmpresa(int $idEmpresa): Collection
    {
        return $this->model->byEmpresa($idEmpresa)->get();
    }

    public function getByEstado(string $estado): Collection
    {
        return $this->model->byEstado($estado)->get();
    }

    public function getByUsuarioGrabo(int $idUsuario): Collection
    {
        return $this->model->where('id_usuario_grabo', $idUsuario)->get();
    }

    public function getByUsuarioEditor(int $idUsuario): Collection
    {
        return $this->model->where('id_usuario_editor', $idUsuario)->get();
    }

    public function getByUsuarioResponsable(int $idUsuario): Collection
    {
        return $this->model->where('id_usuario_responsable', $idUsuario)->get();
    }

    public function getAllWithRelations(): Collection
    {
        return $this->model->with([
            'configuracion',
            'empresa',
            'usuarioGrabo',
            'usuarioEditor',
            'usuarioResponsable',
            'usuarioCargo'
        ])->get();
    }

    public function getByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->model
            ->whereBetween('fecha_grabo', [$startDate, $endDate])
            ->get();
    }

    public function searchByDescription(string $description): Collection
    {
        return $this->model
            ->where('descripcion', 'LIKE', '%' . $description . '%')
            ->get();
    }

    public function getByPeriodoAreaProceso(int $idPeriodo, int $idArea, int $idProceso): Collection
    {
        return $this->model
            ->whereHas('configuracion', function ($query) use ($idPeriodo, $idArea, $idProceso) {
                $query->where('id_periodo', $idPeriodo)
                      ->where('id_area', $idArea)
                      ->where('id_proceso', $idProceso);
            })
            ->get();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function findBy(string $field, $value): Collection
    {
        return $this->model->where($field, $value)->get();
    }

    public function findOneBy(string $field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    public function getDocumentosWithDetails(?int $idPeriodo = null, ?int $idArea = null, ?int $idProceso = null): \Illuminate\Support\Collection
    {
        $query = DB::table('documentos as a')
            ->select([
                'a.id_documento',
                'a.id_configuracion',
                'b.id_periodo',
                'c.label as periodo',
                'b.id_area',
                'd.descripcion as area',
                'b.id_proceso',
                'e.descripcion as proceso',
                'a.fecha_grabo',
                'a.id_usuario_grabo',
                'f.name as usuario_grabo',
                'a.descripcion',
                'a.id_usuario_editor',
                'g.name as usuario_editor',
                'a.id_usuario_responsable',
                'h.name as usuario_responsable',
                'a.estado',
                'a.id_empresa',
                'a.archivo',
                'a.ruta',
                'a.fecha_cargo_archivo',
                'a.id_usuario_cargo',
                'i.name as usuario_cargo'
            ])
            ->join('periodo_area_proceso as b', 'a.id_configuracion', '=', 'b.id_configuracion')
            ->join('periodo as c', 'b.id_periodo', '=', 'c.id_periodo')
            ->join('area as d', 'b.id_area', '=', 'd.id_area')
            ->join('proceso as e', 'b.id_proceso', '=', 'e.id_proceso')
            ->join('users as f', 'a.id_usuario_grabo', '=', 'f.id')
            ->join('users as g', 'a.id_usuario_editor', '=', 'g.id')
            ->join('users as h', 'a.id_usuario_responsable', '=', 'h.id')
            ->leftJoin('users as i', 'a.id_usuario_cargo', '=', 'i.id');

        // Apply filters if provided
        if ($idPeriodo !== null) {
            $query->where('b.id_periodo', $idPeriodo);
        }

        if ($idArea !== null) {
            $query->where('b.id_area', $idArea);
        }

        if ($idProceso !== null) {
            $query->where('b.id_proceso', $idProceso);
        }

        return $query->get();
    }

    /**
     * Get documentos by empresa, periodo and usuario editor with area and proceso information
     * 
     * @param int $idEmpresa ID of the empresa
     * @param int $idPeriodo ID of the periodo
     * @param int $idUsuarioEditor ID of the usuario editor
     * @return \Illuminate\Support\Collection
     */
    public function getDocumentosByEmpresaPeriodoEditor(int $idEmpresa, int $idPeriodo, int $idUsuarioEditor): \Illuminate\Support\Collection
    {
        return DB::table('periodo_area_proceso as a')
            ->select([
                'a.id_configuracion',
                'b.id_documento',
                'a.id_area',
                'c.descripcion as area',
                'a.id_proceso',
                'd.descripcion as proceso',
                'b.descripcion as documento',
                DB::raw("CASE 
                    WHEN b.estado = 'E' THEN 'Editable'
                    WHEN b.estado = 'F' THEN 'Finalizado'
                    ELSE ''
                END as estado"),
                DB::raw("IFNULL(b.archivo,'') as archivo"),
                DB::raw("IFNULL(b.ruta,'') as ruta")
            ])
            ->join('documentos as b', 'a.id_configuracion', '=', 'b.id_configuracion')
            ->join('area as c', 'a.id_area', '=', 'c.id_area')
            ->join('proceso as d', 'a.id_proceso', '=', 'd.id_proceso')
            ->where('a.id_empresa', $idEmpresa)
            ->where('a.id_periodo', $idPeriodo)
            ->where('b.id_usuario_editor', $idUsuarioEditor)
            ->orderBy('c.descripcion')
            ->get();
    }

    /**
     * Save document from base64 string and update documento record
     * 
     * @param string $base64String Base64 encoded document string (PDF, Word, Excel)
     * @param int $idDocumento ID of the documento to update
     * @param int $idUsuarioCargo ID of the user who is uploading the file
     * @return array Result with success status and file information
     */
    public function saveImage(string $base64String, int $idDocumento, int $idUsuarioCargo): array
    {
        try {
            // Find the documento
            $documento = $this->find($idDocumento);
            if (!$documento) {
                return [
                    'success' => false,
                    'message' => 'Documento no encontrado',
                    'data' => null
                ];
            }

            // Decode base64 string
            $documentData = base64_decode($base64String);
            if ($documentData === false) {
                return [
                    'success' => false,
                    'message' => 'Cadena base64 inválida',
                    'data' => null
                ];
            }

            // Get file info from base64 string
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($documentData);
            
            // Validate file type (Word, Excel, PDF only)
            $allowedTypes = [
                'application/pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
                'application/msword', // .doc
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
                'application/vnd.ms-excel' // .xls
            ];
            if (!in_array($mimeType, $allowedTypes)) {
                return [
                    'success' => false,
                    'message' => 'Tipo de archivo inválido. Tipos permitidos: PDF, Word (doc/docx), Excel (xls/xlsx)',
                    'data' => null
                ];
            }

            // Get file extension from mime type
            $extensions = [
                'application/pdf' => 'pdf',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
                'application/msword' => 'doc',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
                'application/vnd.ms-excel' => 'xls'
            ];
            $extension = $extensions[$mimeType];

            // Create year/month path
            $currentDate = now();
            $year = $currentDate->year;
            $month = $currentDate->month;
            $relativePath = "/{$year}/{$month}/";
            $fullPath = "/var/www/html/iso/public_html/documentos{$relativePath}";

            // Create directory if it doesn't exist
            if (!file_exists($fullPath)) {
                if (!mkdir($fullPath, 0755, true)) {
                    return [
                        'success' => false,
                        'message' => 'Error al crear el directorio: ' . $fullPath,
                        'data' => null
                    ];
                }
            }

            // Generate unique filename with UUID (32 characters)
            $uuid = str_replace('-', '', Str::uuid()->toString()); // Remove hyphens to get 32 chars
            $fileName = $uuid . '.' . $extension;
            $fullFilePath = $fullPath . $fileName;

            // Delete old file if exists
            if ($documento->archivo && $documento->ruta) {
                $oldFilePath = "/var/www/html/iso/public_html/documentos{$documento->ruta}{$documento->archivo}";
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Save the document file
            if (file_put_contents($fullFilePath, $documentData) === false) {
                return [
                    'success' => false,
                    'message' => 'Error al guardar el archivo del documento',
                    'data' => null
                ];
            }

            // Update documento with new file information
            $updateResult = $this->update($idDocumento, [
                'archivo' => $fileName,
                'ruta' => $relativePath,
                'fecha_cargo_archivo' => now(),
                'id_usuario_cargo' => $idUsuarioCargo
            ]);

            if (!$updateResult) {
                // If database update fails, delete the created file
                if (file_exists($fullFilePath)) {
                    unlink($fullFilePath);
                }
                return [
                    'success' => false,
                    'message' => 'Error al actualizar el registro del documento',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'message' => 'Documento guardado exitosamente',
                'data' => [
                    'archivo' => $fileName,
                    'ruta' => $relativePath,
                    'full_path' => $fullFilePath,
                    'file_size' => strlen($documentData),
                    'mime_type' => $mimeType,
                    'fecha_cargo_archivo' => now()->toDateTimeString(),
                    'id_usuario_cargo' => $idUsuarioCargo
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al guardar el documento: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Load document as base64 string from documento
     * 
     * @param int $idDocumento ID of the documento
     * @return array Result with success status and base64 document data
     */
    public function loadImage(int $idDocumento): array
    {
        try {
            // Find the documento
            $documento = $this->find($idDocumento);
            if (!$documento) {
                return [
                    'success' => false,
                    'message' => 'Documento no encontrado',
                    'data' => null
                ];
            }

            // Check if documento has a document file
            if (!$documento->archivo || !$documento->ruta) {
                return [
                    'success' => false,
                    'message' => 'No hay archivo de documento asociado con este documento',
                    'data' => null
                ];
            }

            // Build full file path
            $fullFilePath = "/var/www/html/iso/public_html/documentos{$documento->ruta}{$documento->archivo}";

            // Check if file exists
            if (!file_exists($fullFilePath)) {
                return [
                    'success' => false,
                    'message' => 'Archivo de documento no encontrado: ' . $fullFilePath,
                    'data' => null
                ];
            }

            // Read file content
            $documentData = file_get_contents($fullFilePath);
            if ($documentData === false) {
                return [
                    'success' => false,
                    'message' => 'Error al leer el archivo del documento',
                    'data' => null
                ];
            }

            // Get mime type
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($fullFilePath);

            // Convert to base64
            $base64String = base64_encode($documentData);

            return [
                'success' => true,
                'message' => 'Documento cargado exitosamente',
                'data' => [
                    'base64' => $base64String,
                    'mime_type' => $mimeType,
                    'file_size' => strlen($documentData),
                    'archivo' => $documento->archivo,
                    'ruta' => $documento->ruta,
                    'data_uri' => "data:{$mimeType};base64,{$base64String}"
                ]
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al cargar el documento: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    /**
     * Delete document file and clear archivo/ruta fields from documento
     * 
     * @param int $idDocumento ID of the documento
     * @return array Result with success status
     */
    public function deleteImage(int $idDocumento): array
    {
        try {
            // Find the documento
            $documento = $this->find($idDocumento);
            if (!$documento) {
                return [
                    'success' => false,
                    'message' => 'Documento no encontrado',
                    'data' => null
                ];
            }

            // Check if documento has a document file
            if (!$documento->archivo || !$documento->ruta) {
                return [
                    'success' => false,
                    'message' => 'No hay archivo de documento asociado con este documento',
                    'data' => null
                ];
            }

            // Build full file path
            $fullFilePath = "/var/www/html/iso/public_html/documentos{$documento->ruta}{$documento->archivo}";

            // Delete file if it exists
            if (file_exists($fullFilePath)) {
                if (!unlink($fullFilePath)) {
                    return [
                        'success' => false,
                        'message' => 'Error al eliminar el archivo del documento',
                        'data' => null
                    ];
                }
            }

            // Clear archivo and ruta fields
            $updateResult = $this->update($idDocumento, [
                'archivo' => null,
                'ruta' => null,
                'fecha_cargo_archivo' => null,
                'id_usuario_cargo' => null
            ]);

            if (!$updateResult) {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar el registro del documento',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'message' => 'Documento eliminado exitosamente',
                'data' => null
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el documento: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }
}
