<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $table = 'periodo';
    protected $primaryKey = 'id_periodo';

    protected $fillable = [
        'label',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'id_empresa'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public $timestamps = false;
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id');
    }
}
