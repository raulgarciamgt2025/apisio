<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Vw_rol_opcion extends Model
{
    use HasFactory;

    protected $table = 'vw_rol_opcion';

    protected $primaryKey = 'id_rol_opcion';

    protected $fillable = ['id_rol','rol','id_opcion','opcion','id_empresa'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
