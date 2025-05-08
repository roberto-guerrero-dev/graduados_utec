<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facultades extends Model
{
    protected $table = 'facultades';
    protected $primaryKey = 'id_facultad';
    public $timestamps = false;

    protected $fillable = [
        'codigo_facultad', 'nombre_facultad'
    ];
}

