<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opcion extends Model
{
    use HasFactory;

    protected $table = 'opcion';

    protected $primaryKey = 'id_opcion';

    protected $fillable = ['descripcion','ruta','orden','id_menu'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
