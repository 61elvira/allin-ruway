<?php

namespace App\Http\Controllers;

use App\Models\User;

class TrabajadorController extends Controller
{
    public function show($id)
    {
        $trabajador = User::findOrFail($id);

        return view(
            'trabajadores.show',
            compact('trabajador')
        );

    }
}