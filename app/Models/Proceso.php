<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    protected $table = 'proceso';
    protected $primaryKey = 'id_proceso';

    protected $fillable = [
        'descripcion',
        'id_empresa'
    ];
   public $timestamps = false;
    // Relationship with Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id');
    }
}
