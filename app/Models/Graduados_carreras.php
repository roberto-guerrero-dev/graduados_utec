<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraduadosCarreras extends Model
{
    protected $table = 'graduados_carreras';
    protected $primaryKey = 'id_graduados_carreras';
    public $timestamps = false;

    protected $fillable = [
        'carnet_graduado', 'codigo_carrera', 'fecha_graduacion', 'ciclo_graduacion'
    ];
}
