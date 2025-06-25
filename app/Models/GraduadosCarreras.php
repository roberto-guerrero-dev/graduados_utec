<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GraduadosCarreras extends Model
{
    use SoftDeletes;

    protected $table = 'graduados_carreras';
    protected $primaryKey = 'id_graduados_carreras';
    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $fillable = [
        'carnet_graduado', 'codigo_carrera', 'fecha_graduacion', 'ciclo_graduacion', 'deleted_at'
    ];
}
