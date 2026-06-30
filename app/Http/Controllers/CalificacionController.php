<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Contratacion;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    public function create(Contratacion $contratacion)
    {
        return view('calificaciones.create', compact('contratacion'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
        ]);

        Calificacion::create([
            'contratacion_id' => $request->contratacion_id,
            'cliente_id' => auth()->id(),
            'trabajador_id' => $request->trabajador_id,
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('contrataciones.misContrataciones')->with('success', 'Gracias por calificar al trabajador.');
    }

}
