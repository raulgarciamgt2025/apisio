<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PeriodoAreaProceso extends Model
{
    protected $table = 'periodo_area_proceso';

    protected $primaryKey = 'id_configuracion';

    public $timestamps = false;

    protected $fillable = [
        'id_periodo',
        'id_area',
        'id_proceso',
        'id_usuario_asigno',
        'fecha_asigno',
        'id_empresa',
    ];

    protected $casts = [
        'fecha_asigno' => 'datetime',
        'id_periodo' => 'integer',
        'id_area' => 'integer',
        'id_proceso' => 'integer',
        'id_usuario_asigno' => 'integer',
        'id_empresa' => 'integer',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }

    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class, 'id_periodo', 'id_periodo');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }


    public function proceso(): BelongsTo
    {
        return $this->belongsTo(TipoProceso::class, 'id_proceso', 'id_proceso');
    }

    public function usuarioAsigno(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario_asigno', 'id');
    }
}
