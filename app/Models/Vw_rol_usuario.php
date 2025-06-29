<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vw_rol_usuario extends Model
{
    use HasFactory;

    protected $table = 'vw_rol_usuario';

    protected $primaryKey = 'id_rol_usuario';

    protected $fillable = ['id_rol','rol','id_usuario','usuario','id_empresa'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
