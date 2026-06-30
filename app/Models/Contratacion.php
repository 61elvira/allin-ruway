<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contratacion extends Model
{
    protected $table = 'contrataciones';
    protected $fillable = [
        'cliente_id',
        'trabajador_id',
        'servicio_id',
        'fecha',
        'direccion',
        'descripcion',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'trabajador_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function calificacion()
    {
        return $this->hasOne(Calificacion::class);
    }
}
