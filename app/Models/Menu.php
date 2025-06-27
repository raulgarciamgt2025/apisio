<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $primaryKey = 'id_menu';

    protected $fillable = ['descripcion','orden','id_modulo','icono'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
