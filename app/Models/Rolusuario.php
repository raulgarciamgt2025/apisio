<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rolusuario extends Model
{
    use HasFactory;

    protected $table = 'rol_usuario';

    protected $primaryKey = 'id_rol_usuario';

    protected $fillable = ['id_rol','id_usuario','id_empresa'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
