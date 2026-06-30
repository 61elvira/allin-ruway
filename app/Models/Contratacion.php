<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contratacion extends Model
{
    //
    protected $fillable = [
        'cliente_id',
        'trabajador_id',
        'servicio_id',
        'fecha',
        'direccion',
        'descripcion',
        'estado',
    ];
}
