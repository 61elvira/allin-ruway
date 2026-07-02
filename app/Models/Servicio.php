<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function contrataciones()
    {
        return $this->hasMany(Contratacion::class, 'servicio_id');
    }
}