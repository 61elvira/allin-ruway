<?php

namespace App\Http\Controllers;

use App\Models\User;

class TrabajadorController extends Controller
{
    public function show($id)
    {
        $trabajador = User::with('calificaciones')
            ->findOrFail($id);

        $promedio = round(
            $trabajador->calificaciones->avg('puntuacion'),
            1
        );

        $totalResenas = $trabajador->calificaciones->count();

        return view(
            'trabajadores.show',
            compact(
                'trabajador',
                'promedio',
                'totalResenas'
            )
        );
    }
}