<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $fillable = [
        'contratacion_id',
        'cliente_id',
        'trabajador_id',
        'puntuacion',
        'comentario',
    ];

    public function trabajador()
    {
        return $this->belongsTo(User::class, 'trabajador_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function contratacion()
    {
        return $this->belongsTo(Contratacion::class);
    }
}
