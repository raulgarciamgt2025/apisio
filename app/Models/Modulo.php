<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $table = 'modulo';

    protected $primaryKey = 'id_modulo';

    protected $fillable = ['descripcion','orden'];

    protected $hidden = [];


    public $timestamps = false;
    protected $casts = [

    ];
}
