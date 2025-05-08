<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correos extends Model
{
    protected $table = 'correos';
    protected $primaryKey = 'id_correo';
    public $timestamps = false;

    protected $fillable = [
        'carnet_graduado', 'correo'
    ];
}