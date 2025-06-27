<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';

    protected $primaryKey = 'id_empresa';

    protected $fillable = ['nombre','direccion','contacto'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
