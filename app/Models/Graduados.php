<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graduados extends Model
{
    protected $table = 'graduados';
    protected $primaryKey = 'id_graduado';
    public $timestamps = false;

    protected $fillable = [
        'carnet_graduado', 'nombres', 'apellidos', 'genero', 'activo'
    ];
}
