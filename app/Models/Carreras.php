<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carreras extends Model
{
    protected $table = 'carreras';
    protected $primaryKey = 'id_carrera';
    public $timestamps = false;

    protected $fillable = [
        'codigo_carrera', 'nombre', 'modalidad', 'codigo_facultad', 'activo'
    ];
}