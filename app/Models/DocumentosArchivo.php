<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentosArchivo extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'documentos_archivo';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_archivo';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_documento',
        'id_usuario_archivo',
        'fecha_archivo',
        'archivo',
        'ruta',
        'fecha_cargo_archivo',
        'id_usuario_cargo',
        'archivo_final',
        'id_usuario_cargo_archivo_final',
        'fecha_cargo_archivo_final',
        'ruta_final',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'fecha_archivo' => 'datetime',
        'fecha_cargo_archivo' => 'datetime',
        'fecha_cargo_archivo_final' => 'datetime',
    ];

    /**
     * Get the documento that owns the archivo.
     */
    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class, 'id_documento', 'id_documento');
    }

    /**
     * Get the user who created the archivo.
     */
    public function usuarioArchivo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_archivo', 'id');
    }

    /**
     * Get the user who uploaded the file.
     */
    public function usuarioCargo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_cargo', 'id');
    }

    /**
     * Get the user who uploaded the final file.
     */
    public function usuarioCargoArchivoFinal(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_cargo_archivo_final', 'id');
    }
}
