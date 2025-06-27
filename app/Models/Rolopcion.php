<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class RolOpcion extends Model
{
    use HasFactory;

    protected $table = 'rol_opcion';

    protected $primaryKey = 'id_rol_opcion';

    protected $fillable = ['id_rol','id_opcion','id_empresa'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
