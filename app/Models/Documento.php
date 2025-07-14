<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documento extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'documentos';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_documento';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_configuracion',
        'fecha_grabo',
        'id_usuario_grabo',
        'descripcion',
        'id_usuario_editor',
        'id_usuario_responsable',
        'estado',
        'id_empresa',
        'archivo',
        'ruta',
        'fecha_cargo_archivo',
        'id_usuario_cargo',
        'archivo_final',
        'ruta_final',
        'id_usuario_cargo_archivo_final',
        'fecha_cargo_archivo_final',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha_grabo' => 'datetime',
        'fecha_cargo_archivo' => 'datetime',
        'fecha_cargo_archivo_final' => 'datetime',
        'id_configuracion' => 'integer',
        'id_usuario_grabo' => 'integer',
        'id_usuario_editor' => 'integer',
        'id_usuario_responsable' => 'integer',
        'id_usuario_cargo' => 'integer',
        'id_usuario_cargo_archivo_final' => 'integer',
        'id_empresa' => 'integer',
    ];

    /**
     * Estado constants
     */
    const ESTADO_ELABORACION = 'E';
    const ESTADO_FINALIZADO = 'F';
    const ESTADO_OBSOLETO = 'O';

    /**
     * Get the configuracion that owns the documento.
     */
    public function configuracion(): BelongsTo
    {
        return $this->belongsTo(PeriodoAreaProceso::class, 'id_configuracion', 'id_configuracion');
    }

    /**
     * Get the empresa that owns the documento.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }

    /**
     * Get the user who created this documento.
     */
    public function usuarioGrabo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_grabo', 'id');
    }

    /**
     * Get the user who edits this documento.
     */
    public function usuarioEditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_editor', 'id');
    }

    /**
     * Get the user responsible for this documento.
     */
    public function usuarioResponsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_responsable', 'id');
    }

    /**
     * Get the user who uploaded the file for this documento.
     */
    public function usuarioCargo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_cargo', 'id');
    }

    /**
     * Get the user who uploaded the final file for this documento.
     */
    public function usuarioCargoArchivoFinal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_cargo_archivo_final', 'id');
    }

    /**
     * Scope a query to only include documentos with specific estado.
     */
    public function scopeByEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope a query to only include documentos by empresa.
     */
    public function scopeByEmpresa($query, $idEmpresa)
    {
        return $query->where('id_empresa', $idEmpresa);
    }

    /**
     * Scope a query to only include documentos by configuracion.
     */
    public function scopeByConfiguracion($query, $idConfiguracion)
    {
        return $query->where('id_configuracion', $idConfiguracion);
    }

    /**
     * Get estado description
     */
    public function getEstadoDescriptionAttribute()
    {
        return match($this->estado) {
            self::ESTADO_ELABORACION => 'En Elaboración',
            self::ESTADO_FINALIZADO => 'Finalizado',
            self::ESTADO_OBSOLETO => 'Obsoleto',
            default => 'Desconocido'
        };
    }
}
