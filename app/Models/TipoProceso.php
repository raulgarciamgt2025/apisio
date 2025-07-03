<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProceso extends Model
{
    use HasFactory;

    protected $table = 'tipo_proceso';
    protected $primaryKey = 'id_tipo_proceso';

    protected $fillable = [
        'descripcion',
        'estado',
        'id_empresa'
    ];

    // Relationship with Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id');
    }
}
