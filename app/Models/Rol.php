<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Rol extends Model
{
    use HasFactory;

    protected $table = 'rol';

    protected $primaryKey = 'id_rol';

    protected $fillable = ['descripcion','id_empresa'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
