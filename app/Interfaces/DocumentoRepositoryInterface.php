<?php

namespace App\Interfaces;

interface DocumentoRepositoryInterface extends GenericRepositoryInterface
{
    /**
     * Get documentos by configuracion
     */
    public function getByConfiguracion(int $idConfiguracion): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos by empresa
     */
    public function getByEmpresa(int $idEmpresa): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos by estado
     */
    public function getByEstado(string $estado): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos by usuario grabo
     */
    public function getByUsuarioGrabo(int $idUsuario): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos by usuario editor
     */
    public function getByUsuarioEditor(int $idUsuario): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos by usuario responsable
     */
    public function getByUsuarioResponsable(int $idUsuario): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos with relationships
     */
    public function getAllWithRelations(): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos by date range
     */
    public function getByDateRange(string $startDate, string $endDate): \Illuminate\Database\Eloquent\Collection;

    /**
     * Search documentos by description
     */
    public function searchByDescription(string $description): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos by periodo area proceso
     */
    public function getByPeriodoAreaProceso(int $idPeriodo, int $idArea, int $idProceso): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get documentos with detailed information including related data
     */
    public function getDocumentosWithDetails(?int $idPeriodo = null, ?int $idArea = null, ?int $idProceso = null): \Illuminate\Support\Collection;

    /**
     * Get documentos by empresa, periodo and usuario editor with area and proceso information
     */
    public function getDocumentosByEmpresaPeriodoEditor(int $idEmpresa, int $idPeriodo, int $idUsuarioEditor): \Illuminate\Support\Collection;

    /**
     * Save document from base64 string and update documento record
     */
    public function saveImage(string $base64String, int $idDocumento, int $idUsuarioCargo): array;

    /**
     * Save final document from base64 string and update documento record
     */
    public function saveFinalImage(string $base64String, int $idDocumento, int $idUsuarioCargo): array;

    /**
     * Load document as base64 string from documento
     */
    public function loadImage(int $idDocumento): array;

    /**
     * Delete document file and clear archivo/ruta fields from documento
     */
    public function deleteImage(int $idDocumento): array;

    /**
     * Load final document as base64 string from documento
     */
    public function loadFinalImage(int $idDocumento): array;

    /**
     * Delete final document file and clear archivo/ruta fields from documento
     */
    public function deleteFinalImage(int $idDocumento): array;

    /**
     * Archive document and update its status
     */
    public function archiveDocument(int $idUsuarioArchivo, int $idDocumento): array;
}
