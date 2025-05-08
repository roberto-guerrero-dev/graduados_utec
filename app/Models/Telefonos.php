<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefonos extends Model
{
    protected $table = 'telefonos';
    protected $primaryKey = 'id_telefono';
    public $timestamps = false;

    protected $fillable = [
        'carnet_graduado', 'telefono'
    ];
}