<?php

namespace App\Interfaces;

interface PeriodoAreaProcesoRepositoryInterface extends GenericRepositoryInterface
{
    /**
     * Get configurations by periodo
     */
    public function getByPeriodo(int $idPeriodo): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get configurations by area
     */
    public function getByArea(int $idArea): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get configurations by proceso
     */
    public function getByProceso(int $idProceso): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get configurations by empresa
     */
    public function getByEmpresa(int $idEmpresa): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get configurations by usuario who assigned
     */
    public function getByUsuarioAsigno(int $idUsuario): \Illuminate\Database\Eloquent\Collection;

    /**
     * Get configurations with relationships
     */
    public function getAllWithRelations(): \Illuminate\Database\Eloquent\Collection;

    /**
     * Check if configuration exists for given parameters
     */
    public function existsConfiguration(int $idPeriodo, int $idArea, int $idProceso, int $idEmpresa): bool;

    /**
     * Get configuration by unique combination
     */
    public function getByUniqueConfiguration(int $idPeriodo, int $idArea, int $idProceso, int $idEmpresa): ?\App\Models\PeriodoAreaProceso;
}
